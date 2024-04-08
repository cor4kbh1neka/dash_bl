<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\DepoWd;
use App\Models\Transactions;

date_default_timezone_set('Asia/Jakarta');


class DepoWdController extends Controller
{
    public function deposit(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:50',
                'amount' => 'required|numeric',
                'keterangan' => 'nullable|max:20',
                'bank' => 'required|max:100',
                'mbank' => 'required|max:100',
                'mnamarek' => 'required|max:150',
                'mnorek' => 'required|max:30',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $dataDepoWd = DepoWd::where('username', $request->username)->where('jenis', 'DP')->where('status', '0')->first();
            if ($dataDepoWd) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Gagal melakukan deposit'
                ], 400);
            }

            /* Request API check transaction */
            $txnid = $this->generateTxnid('D');
            if ($txnid === null) {
                return $this->errorResponse($request->username, 'Txnid error');
            }
            /* Request Ke Database Internal */
            $data = $request->all();
            $data["jenis"] = "DP";
            $data["txnid"] = $txnid;
            $data["status"] = 0;
            $data["approved_by"] = null;
            DepoWd::create($data);

            return response()->json([
                'status' => 'Success',
                'message' => 'Deposit sedang diproses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function withdrawal(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:50',
                'amount' => 'required|numeric',
                'mbank' => 'required|max:100',
                'mnamarek' => 'required|max:150',
                'mnorek' => 'required|max:30',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $checkBalance = $this->reqApiBalance($request->username);
            if ($checkBalance["balance"] < $request->amount) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Balance tidak cukup'
                ], 400);
            }

            if ($checkBalance["error"]["id"] !== 0) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => $checkBalance["error"]["msg"]
                ], 400);
            }

            $dataDepoWd = DepoWd::where('username', $request->username)->where('jenis', 'WD')->where('status', '0')->first();
            if ($dataDepoWd) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Gagal melakukan withdrawal'
                ], 400);
            }

            /* Request API check transaction */
            $txnid = $this->generateTxnid('W');
            if ($txnid === null) {
                return $this->errorResponse($request->username, 'Txnid error');
            }

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["keterangan"] = null;
            $data["bank"] = null;
            $data["jenis"] = "WD";
            $data["txnid"] = $txnid;
            $data["status"] = 0;
            $data["approved_by"] = null;
            DepoWd::create($data);

            return response()->json([
                'status' => 'Success',
                'message' => 'Withdrawal sedang diproses'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBalance(Request $request, $username)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $data = $this->reqApiBalance($username);

        if ($data["error"]["id"] === 0) {
            $results = [
                "username" => $data["username"],
                "balance" => $data["balance"] + $this->saldoBerjalan($username),
            ];
            return $results;
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => $data["error"]["msg"]
            ]);
        }
    }

    private function reqApiBalance($username)
    {
        $dataApiCheckBalance = [
            "Username" => $username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];

        return $this->requestApi('get-player-balance', $dataApiCheckBalance);
    }

    public function getLastStatusTransaction(Request $request, $jenis, $username)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        if ($jenis == 'DP') {
            $tipe = "Deposit";
        } else if ($jenis == 'WD') {
            $tipe = "Withdrawal";
        } else {
            return response()->json([
                'status' => 'Fail',
                'message' => 'Status transaksi tidak falid!'
            ]);
        }

        $dataLastDepo = DepoWd::where('username', $username)->where('jenis', $jenis)->orderBy('created_at', 'desc')->first();

        if ($dataLastDepo) {
            if ($dataLastDepo->status == 1) {
                return response()->json([
                    'status' => 'Success',
                    'message' => $tipe . ' berhasil diporses!'
                ]);
            } else if ($dataLastDepo->status == 2) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => $tipe . ' gagal diproses!'
                ]);
            } else if ($dataLastDepo->status == 0) {
                return response()->json([
                    'status' => 'Waitting',
                    'message' => $tipe . ' sedang diproses!'
                ]);
            }
        }

        return response()->json([
            'status' => 'None',
            'message' => 'Tidak ada status ' . $tipe . '!'
        ]);
    }


    public function indexdeposit()
    {
        $datDepo = DepoWd::where('status', 0)->where('jenis', 'DP')->orderBy('created_at', 'desc')->get();
        return view('depowd.indexdepo', [
            'title' => 'List Deposit',
            'data' => $datDepo,
            'totalnote' => 0
        ]);
    }

    public function indexwithdrawal()
    {
        $datWd = DepoWd::where('status', 0)->where('jenis', 'WD')->orderBy('created_at', 'desc')->get();
        return view('depowd.indexwithdrawal', [
            'title' => 'List Withdrawal',
            'data' => $datWd,
            'totalnote' => 0
        ]);
    }


    public function indexhistory()
    {
        $datHistory = DepoWd::whereIn('status', [1, 2])->orderBy('created_at', 'desc')->get();
        return view('depowd.indexhistory', [
            'title' => 'List History',
            'data' => $datHistory,
            'totalnote' => 0
        ]);
    }

    public function indexmanual()
    {
        return view('depowd.indexmanual', [
            'title' => 'Proses Manual',
            'totalnote' => 0,
            'jenis' => 'DPM',
            'errorCode' => 0,
            'message' => ''
        ]);
    }

    public function storemanual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'jenis' => 'required',
            'keterangan' => 'nullable|max:20',
            'amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            try {
                $txnid = $this->generateTxnid('D');
                if ($txnid === null) {
                    return $this->errorResponse($request->username, 'Txnid error');
                }

                $data = $request->all();
                $data["bank"] = "";
                $data["mbank"] = "";
                $data["mnamarek"] = "";
                $data["mnorek"] = "";
                $data["txnid"] = $txnid;
                $data["status"] = 1;
                $data["approved_by"] = Auth::user()->username;
                $result = DepoWd::create($data);

                if ($result) {
                    $dataAPI = [
                        "Username" => $result->username,
                        "TxnId" => $result->txnid,
                        "Amount" => $result->amount,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];

                    if ($result->jenis == 'DPM') {
                        $req = $this->requestApi('deposit', $dataAPI);
                    } elseif ($result->jenis == 'WDM') {
                        $dataAPI["IsFullAmount"] = false;
                        $req = $this->requestApi('withdraw', $dataAPI);
                    } else {
                        return view('depowd.indexmanual', [
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $request->jenis,
                            'errorCode' => 500,
                            'message' => 'Gagal melakukan transaksi!'
                        ]);
                    }
                    if ($req["error"]["id"] !== 0) {
                        return view('depowd.indexmanual', [
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $request->jenis,
                            'errorCode' => 500,
                            'message' => 'Gagal melakukan transaksi!'
                        ]);
                    }
                    return view('depowd.indexmanual', [
                        'title' => 'Proses Manual',
                        'totalnote' => 0,
                        'jenis' => $result->jenis,
                        'errorCode' => 200,
                        'message' => 'Transaksi berhasil!'
                    ]);
                }
                return view('depowd.indexmanual', [
                    'title' => 'Proses Manual',
                    'totalnote' => 0,
                    'jenis' => $request->jenis,
                    'errorCode' => 500,
                    'message' => 'Gagal melakukan transaksi!'
                ]);
            } catch (\Exception $e) {
                // dd($e->getMessage());
                return view('depowd.indexmanual', [
                    'title' => 'Proses Manual',
                    'totalnote' => 0,
                    'jenis' => $request->jenis,
                    'errorCode' => 500,
                    'message' => 'Gagal melakukan transaksi!'
                ]);
            }
        }
    }

    public function approve(Request $request)
    {
        try {
            $ids = $request->id;
            foreach ($ids as $id) {
                $dataDepo = DepoWd::where('id', $id)->where('status', 0)->first();

                if ($dataDepo) {
                    $updateDepo = $dataDepo->update(['status' => 1, 'approved_by' => Auth::user()->username]);

                    if ($updateDepo) {
                        /* Request Ke API SBO Depo*/
                        $dataAPI = [
                            "Username" => $dataDepo->username,
                            "TxnId" => $dataDepo->txnid,
                            "Amount" => $dataDepo->amount,
                            "CompanyKey" => env('COMPANY_KEY'),
                            "ServerId" => env('SERVERID')
                        ];

                        if ($dataDepo->jenis == 'DP') {
                            $resultsApi = $this->requestApi('deposit', $dataAPI);
                        } elseif ($dataDepo->jenis == 'WD') {
                            $dataAPI["IsFullAmount"] = false;
                            $resultsApi = $this->requestApi('withdraw', $dataAPI);
                        } else {
                            return response()->json([
                                'status' => 'Error',
                                'message' => 'Gagal melakukan transaksi!'
                            ], 500);
                        }
                        if ($resultsApi["error"]["id"] !== 0) {
                            DepoWd::where('id', $id)->update(['status' => 0, 'approved_by' => null]);
                            return response()->json([
                                'status' => 'Error',
                                'message' => $resultsApi["error"]["msg"]
                            ], 500);
                        }
                    }
                }
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Accept berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request)
    {
        try {
            $ids = $request->id;
            foreach ($ids as $id) {
                DepoWd::where('id', $id)->where('status', 0)->update(['status' => 2, 'approved_by' => Auth::user()->username]);
            }
            return response()->json([
                'status' => 'Success',
                'message' => 'Reject berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    private function generateTxnid($jenis)
    {
        $characters = '0123456789';
        $length = $jenis == 'D' ? 17 : 10;

        $maxAttempts = 5;
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randomString = $jenis . $randomString;
            $dataApiCheckBalance = [
                "TxnId" => $randomString,
                "CompanyKey" => env('COMPANY_KEY'),
                "ServerId" => env('SERVERID')
            ];

            $resultsApi = $this->requestApi('check-transaction-status', $dataApiCheckBalance);
            if ($resultsApi["error"]["id"] === 4602) {
                return $randomString;
            }

            $attempts++;
        }

        return null;
    }

    private function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function validasiBearer(Request $request)
    {
        $token = $request->bearerToken();
        $expectedToken = env('BEARER_TOKEN');

        if ($token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        return true;
    }

    private function errorResponse($username, $errorMessage)
    {
        return response()->json([
            'AccountName' => $username,
            'ErrorMessage' => $errorMessage
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    private function saldoBerjalan($username)
    {
        $allTransactionTransaction = $this->getAllTransactions($username);

        $dataAllTransactionsWD = $allTransactionTransaction->where('jenis', 'W')->sum('amount');
        $dataAllTransactionsDP = $allTransactionTransaction->where('jenis', 'D')->sum('amount');

        $saldoBerjalan = $dataAllTransactionsDP  - $dataAllTransactionsWD;

        return $saldoBerjalan;
    }

    private function getAllTransactions($username)
    {
        $transactions = Transactions::where('username', $username)->get();
        $transactionTransactions = collect();

        foreach ($transactions as $transaction) {
            $transactions = $transaction->transactionstatus->flatMap(function ($status) {
                return $status->transactionsaldo;
            });

            $transactionTransactions = $transactionTransactions->concat($transactions);
        }
        return $transactionTransactions;
    }
}
