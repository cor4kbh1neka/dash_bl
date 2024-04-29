<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\DepoWd;
use App\Models\Xdpwd;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\Outstanding;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\Xtrans;
use App\Models\Xcountwddp;

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
                'balance' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 400);
            }

            $dataMember = Member::where('username', $request->username)->first();
            if (!$dataMember) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Username tidak terdaftar'
                ], 400);
            }

            $dataDepoWd = DepoWd::where('username', $request->username)->where('jenis', 'DP')->where('status', '0')->first();

            if ($dataDepoWd) {
                return response()->json([
                    'status' => 'Fail',
                    'message' => 'Gagal melakukan deposit'
                ], 400);
            }

            $dataDepoWd = DepoWd::where('username', $request->username)->where('jenis', 'DP')->where('status', '1')->first();
            if (!$dataDepoWd) {
                Member::where('username', $request->username)
                    ->update([
                        'status' => '9',
                        'is_notnew' => true,
                    ]);
            }

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["jenis"] = "DP";
            $data["txnid"] = null;
            $data["status"] = 0;
            $data["approved_by"] = null;

            DepoWd::create($data);
            Xdpwd::create($data);

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
                'bank' => 'required|max:100',
                'mbank' => 'required|max:100',
                'mnamarek' => 'required|max:150',
                'mnorek' => 'required|max:30',
                'balance' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 400);
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
            $data["jenis"] = "WD";
            $data["txnid"] = $txnid;
            $data["status"] = 0;
            $data["approved_by"] = null;
            $dataWD = DepoWd::create($data);

            if ($dataWD) {
                Xdpwd::create($data);
                $dataAPI = [
                    "Username" => $dataWD->username,
                    "TxnId" => $txnid,
                    "Amount" => $dataWD->amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID'),
                    "IsFullAmount" => false
                ];
                $resultsApi = $this->requestApi('withdraw', $dataAPI);
                if ($resultsApi["error"]["id"] !== 0) {
                    DepoWd::destroy($dataWD->id);

                    return response()->json([
                        'status' => 'Error',
                        'message' => $resultsApi["error"]["msg"]
                    ], 500);
                }
            }

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
                // "balance" => $data["balance"],
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


    public function indexhistory(Request $request, $jenis = "")
    {
        $username = $request->query('search_username');
        $tipe = $request->query('search_tipe');
        $agent = $request->query('search_agent');
        $tgldari = $request->query('search_tgl_dari') != '' ? date('Y-m-d 00:00:00', strtotime($request->query('search_tgl_dari'))) : $request->query('search_tgl_dari');
        $tglsampai =  $request->query('tgldari') != '' ?  date('Y-m-d 23:59:59', strtotime($request->query('tgldari'))) : $request->query('tgldari');

        $datHistory = DepoWd::whereIn('status', [1, 2])
            ->when($jenis, function ($query) use ($jenis) {
                if ($jenis === 'M') {
                    return $query->whereIn('jenis', ['DPM', 'WDM']);
                } else {
                    return $query->where('jenis', $jenis);
                }
            })
            ->when($username, function ($query) use ($username) {
                return $query->where('username', $username);
            })
            ->when($tipe, function ($query) use ($tipe) {
                return $query->where('tipe', $tipe);
            })
            ->when($agent, function ($query) use ($agent) {
                return $query->where('approved_by', $agent);
            })
            ->when($tgldari && $tglsampai, function ($query) use ($tgldari, $tglsampai) {
                return $query->whereBetween('created_at', [$tgldari, $tglsampai]);
            })
            ->orderBy('created_at', 'desc')->get();

        return view('depowd.indexhistory', [
            'title' => 'List History',
            'data' => $datHistory,
            'totalnote' => 0,
            'jenis' => $jenis,
            'username' => $username,
            'tipe' => $tipe,
            'agent' => $agent,
            'tgldari' => $tgldari != '' ? date("Y-m-d", strtotime($tgldari)) : $tgldari,
            'tglsampai' => $tglsampai != '' ? date("Y-m-d", strtotime($tglsampai)) : $tglsampai,
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
            return response()->json(['errors' => $validator->errors()->all()], 400);
        } else {
            try {
                $txnid = $this->generateTxnid('D');
                if ($txnid === null) {
                    return $this->errorResponse($request->username, 'Txnid error');
                }

                $checkDataMember = Member::where('username', $request->username)->first();
                if (!$checkDataMember) {
                    return $this->errorResponse($request->username, 'Username tidak terdaftar');
                }

                $data = $request->all();
                $data["bank"] = "";
                $data["mbank"] = "";
                $data["mnamarek"] = "";
                $data["mnorek"] = "";
                $data["txnid"] = $txnid;
                $data["status"] = 1;
                $data["balance"] = $data["saldo"];
                $data["approved_by"] = Auth::user()->username;

                if ($data["jenis"] == 'WDM') {
                    if ($data["saldo"] < $data["amount"]) {
                        return $this->errorResponse($request->username, 'Balance tidak mencukupi');
                    }
                }
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
                        return redirect()->route('manualds')->with([
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $request->jenis,
                            'errorCode' => 500,
                            'message' => 'Gagal melakukan transaksi!'
                        ]);
                    }
                    if ($req["error"]["id"] !== 0) {
                        return redirect()->route('manualds')->with([
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $request->jenis,
                            'errorCode' => 500,
                            'message' => 'Gagal melakukan transaksi!'
                        ]);
                    }
                    return redirect()->route('manualds')->with([
                        'title' => 'Proses Manual',
                        'totalnote' => 0,
                        'jenis' => $result->jenis,
                        'errorCode' => 200,
                        'message' => 'Transaksi berhasil!'
                    ]);
                }
                return redirect()->route('manualds')->with([
                    'title' => 'Proses Manual',
                    'totalnote' => 0,
                    'jenis' => $request->jenis,
                    'errorCode' => 500,
                    'message' => 'Gagal melakukan transaksi!'
                ]);
            } catch (\Exception $e) {
                return redirect()->route('manualds')->with([
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
                $txnid = $this->generateTxnid('D');
                if ($dataDepo) {
                    $updateDepo = $dataDepo->update(['status' => 1, 'approved_by' => Auth::user()->username]);

                    /* Create Member Aktif */
                    $dataMemberAktif = MemberAktif::where('username', $dataDepo->username)->first();
                    if (!$dataMemberAktif) {
                        $dataMemberAktif->create([
                            'username' => $dataDepo->username,
                            'referral' => $dataDepo->referral
                        ]);
                    }


                    /* delete transaction Xdpwd */
                    $dataToDelete = Xdpwd::where('username', $dataDepo->username)->where('jenis', $dataDepo->jenis)->first();
                    if ($dataToDelete) {
                        $dataToDelete->delete();
                    }

                    /* count xdepo wd */
                    $dataXtrans = Xtrans::where('username', $dataDepo->username)->where('bank', $dataDepo->bank)->first();
                    if (!$dataXtrans) {
                        if ($dataDepo->jenis == 'WD') {
                            Xtrans::create([
                                'bank' => $dataDepo->bank,
                                'username' => $dataDepo->username,
                                'count_wd' => 1,
                                'sum_wd' => $dataDepo->amount,
                                'count_dp' => 0,
                                'sum_dp' => 0
                            ]);
                        } else {
                            Xtrans::create([
                                'bank' => $dataDepo->bank,
                                'username' => $dataDepo->username,
                                'count_wd' => 0,
                                'sum_wd' => 0,
                                'count_dp' => 1,
                                'sum_dp' => $dataDepo->amount
                            ]);
                        }
                    } else {
                        if ($dataDepo->jenis == 'WD') {
                            $dataXtrans->update([
                                'count_wd' => $dataXtrans->count_wd + 1,
                                'sum_wd' => $dataXtrans->sum_wd + $dataDepo->amount
                            ]);
                        } else {
                            $dataXtrans->update([
                                'count_dp' => $dataXtrans->count_dp + 1,
                                'sum_dp' => $dataXtrans->sum_dp + $dataDepo->amount
                            ]);
                        }
                    }

                    if ($dataDepo->jenis !== 'WD') {
                        if ($updateDepo) {
                            $dataAPI = [
                                "Username" => $dataDepo->username,
                                "TxnId" => $txnid,
                                "Amount" => $dataDepo->amount,
                                "CompanyKey" => env('COMPANY_KEY'),
                                "ServerId" => env('SERVERID')
                            ];

                            if ($dataDepo->jenis == 'DP') {
                                $resultsApi = $this->requestApi('deposit', $dataAPI);
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
                            } else if ($resultsApi["error"]["id"] === 0) {
                                DepoWd::where('id', $id)->update(['txnid' => $txnid]);
                                $dataMember = Member::where('username', $dataDepo->username)
                                    ->where('status', 9)
                                    ->where('is_notnew', true)
                                    ->first();

                                if ($dataMember) {
                                    $dataMember->update([
                                        'status' => 1
                                    ]);
                                }
                            }
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
                //UPDATE STATUS CANCEL
                $updateStatusTransaction = DepoWd::where('id', $id)->first();
                if ($updateStatusTransaction) {
                    $updateStatusTransaction->update(['status' => 2, 'approved_by' => Auth::user()->username]);

                    /* delete transaction Xdpwd */
                    $dataToDelete = Xdpwd::where('username', $updateStatusTransaction->username)->where('jenis', $updateStatusTransaction->jenis)->first();
                    if ($dataToDelete) {
                        $dataToDelete->delete();
                    }
                } else {
                    return response()->json([
                        'status' => 'Error',
                        'message' => 'Data tidak ditemukan'
                    ], 500);
                }

                if ($updateStatusTransaction->jenis == 'WD') {
                    //GET TXNID
                    $txnid = $this->generateTxnid('D');
                    if ($txnid === null) {
                        $updateStatusTransaction->update(['status' => 0, 'approved_by' => null]);
                        return $this->errorResponse($updateStatusTransaction->username, 'Txnid error');
                    }

                    //PROSES WD
                    $dataAPI = [
                        "Username" => $updateStatusTransaction->username,
                        "TxnId" => $txnid,
                        "Amount" => $updateStatusTransaction->amount,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];
                    $resultsApi = $this->requestApi('deposit', $dataAPI);
                    if ($resultsApi["error"]["id"] !== 0) {
                        $updateStatusTransaction->update(['status' => 0, 'approved_by' => null]);

                        return response()->json([
                            'status' => 'Error',
                            'message' => $resultsApi["error"]["msg"]
                        ], 500);
                    }
                }
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

    public function getHistoryDepoWd($username)
    {

        $data = DepoWd::where('username', $username)
            ->select('id', 'username', 'balance', 'amount', 'jenis', 'status', 'updated_at')
            // ->when($jenis, function ($query) use ($jenis) {
            //     return $query->where('jenis', $jenis);
            // })
            // ->whereDate('created_at', '>=', '2024-01-01')
            // ->whereDate('created_at', '<=', '2024-01-31')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();


        foreach ($data as $item) {
            if ($item['status'] == 1) {
                $item['status'] = 'accept';
            } elseif ($item['status'] == 2) {
                $item['status'] = 'cancel';
            } elseif ($item['status'] == 0) {
                $item['status'] = 'pending';
            }

            if ($item['jenis'] === 'DPM' || $item['jenis'] === 'DP') {
                $item['balance'] = $item['status'] == 'accept' ?  $item['balance'] + $item['amount'] : $item['balance'];
            } else {
                $item['balance'] = $item['status'] == 'cancel' ?  $item['balance'] : $item['balance'] - $item['amount'];
            }
        }
        return $data;
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

    public function getBalancePlayer($username)
    {
        try {
            $apiBalance = $this->reqApiBalance($username)["balance"];
            $saldoBerjalan = $this->saldoBerjalan($username);

            return $apiBalance + $saldoBerjalan;
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    // public function getCountDataDPW()
    // {
    //     $countDataDP = Xdpwd::where('jenis', 'DP')->where('status', 0)->count();
    //     $countDataWD = Xdpwd::where('jenis', 'WD')->where('status', 0)->count();

    //     $dataOuts = Outstanding::get();
    //     $dataOuts = $dataOuts->groupBy('username')->map(function ($group) {
    //         $totalAmount = $group->sum('amount');
    //         $count = $group->count();
    //         return [
    //             'username' => $group->first()['username'],
    //             'totalAmount' => $totalAmount,
    //             'count' => $count,
    //         ];
    //     });

    //     $data = [
    //         'dataWD' => $countDataWD,
    //         'dataDP' => $countDataDP,
    //         'dataOuts' => $dataOuts->count()
    //     ];

    //     return $data;
    // }

    public function getTransactions()
    {
        $data = Transactions::orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function getTransactionStatus()
    {
        $data = TransactionStatus::orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function getTransactionSaldo()
    {
        $data = TransactionSaldo::orderBy('created_at', 'desc')->get();
        return $data;
    }
}
