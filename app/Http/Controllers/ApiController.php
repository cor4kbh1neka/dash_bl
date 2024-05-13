<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\Member;
use App\Models\Xreferral;
use App\Models\MemberAktif;
use App\Models\Xdpwd;
use App\Models\DepoWd;
use App\Models\Groupbank;
use App\Models\Outstanding;
use Carbon\Carbon;


use Illuminate\Support\Facades\Http;

class ApiController extends Controller

{
    public function login(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        // return $validasiBearer;
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $iswap = $request->iswap;
        $device = $request->device;


        if ($device != 'd') {
            $device = 'm';
        }

        try {
            $dataLogin['Username'] = $username;
            $dataLogin['CompanyKey'] = env('COMPANY_KEY');
            $dataLogin['Portfolio'] = env('PORTFOLIO');
            $dataLogin['IsWapSports'] = $iswap;
            $dataLogin['ServerId'] = "YY-TEST";
            $getLogin = $this->requestApiLogin($dataLogin);
            if ($getLogin["url"] !== "") {
                $getLogin["url"] = 'https://' . $getLogin["url"] .  '/welcome2.aspx?token=token&lang=en&oddstyle=ID&theme=black&oddsmode=double&device=' . $device;
            }

            return $getLogin;
        } catch (\Exception $e) {
            return [
                'AccountName' => $username,
                'Balance' => 0,
                'ErrorCode' => 99,
                'ErrorMessage' => 'Internal Error'
            ];;
        }
    }

    function requestApiLogin($data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/login.aspx';

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
        return ['url' => $responseData["url"]];
    }

    public function historyLog(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $ipaddress = $request->ipaddress;

        try {
            $member = Member::where('username', $username)->firstOrFail();
            $member->update([
                'ip_log' => $ipaddress,
                'lastlogin' => now(),
                'domain' => $request->getHost()
            ]);

            return response()->json(['message' => 'Log berhasil tersimpan!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan log.'], 500);
        }
    }

    public function register(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }
        $ipaddress = $request->ipadress;
        $data = [
            "Username" => $request->Username,
            "UserGroup" => "c",
            "Agent" => env('AGENTID'),
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => "YY-TEST"
        ];

        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/register-player.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }
        if ($responseData["error"]["id"] === 0) {
            Member::create([
                'username' => $request->Username,
                'referral' => $request->Referral,
                'bank' => $request->xybanknamexyy,
                'namarek' => $request->xybankuserxy,
                'norek' => $request->xxybanknumberxy,
                'nohp' => 0,
                'balance' => 0,
                'ip_reg' => $ipaddress,
                'ip_log' => null,
                'lastlogin' => null,
                'domain' => null,
                'lastlogin2' => null,
                'domain2' => null,
                'lastlogin3' => null,
                'domain3' => null,
                'status' => 0
            ]);

            $dataXreferral = Xreferral::where('username', $request->Referral)->first();
            if ($dataXreferral) {
                $dataXreferral->update([
                    'count_referral' => $dataXreferral->count_referral + 1
                ]);
            } else {
                if ($request->Referral != '') {
                    Xreferral::create([
                        'username' => $request->Referral,
                        'count_referral' => 1,
                        'sum_amount' => 0
                    ]);
                }
            }

            return response()->json([
                'message' => 'Data berhasil disimpan.'
            ], 200);
        } else {
            return response()->json([
                'message' => $responseData["error"]["msg"] ?? 'Error tidak teridentifikasi.'
            ], 400);
        }
    }

    public function getRecomMatch(Request $request)
    {
        // $token = $request->bearerToken();
        // $expectedToken = env('BEARER_TOKEN');
        // if ($token !== $expectedToken) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }

        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $data = [
            "language" => 'en',
            "companyKey" => env('COMPANY_KEY'),
            "serverId" =>  env('SERVERID')
        ];

        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/information/get-recommend-matches.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
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

    public function cekuserreferral(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;

        $dataMemberAktif = MemberAktif::where('referral', $username)->first();
        if ($dataMemberAktif) {
            return response()->json(['message' => 'Referral tersedia'], 200);
        } else {
            $dataMember = Member::where('username', $username)->first();
            if ($dataMember) {
                return response()->json(['message' => 'Referral tersedia'], 200);
            } else {
                return response()->json(['message' => 'Referral tidak ditemukan'], 404);
            }
        }
    }

    public function deposit(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        try {
            // $validator = Validator::make($request->all(), [
            //     'username' => 'required|max:50',
            //     'amount' => 'required|numeric',
            //     'keterangan' => 'nullable|max:20',
            //     'bank' => 'required|max:100',
            //     'mbank' => 'required|max:100',
            //     'mnamarek' => 'required|max:150',
            //     'mnorek' => 'required|max:30',
            //     'balance' => 'required|numeric',
            //     'referral' => 'nullable',
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(['errors' => $validator->errors()->all()], 400);
            // }

            // $dataMember = Member::where('username', strtolower($request->username))->first();
            // if (!$dataMember) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Username tidak terdaftar'
            //     ], 400);
            // }

            // $dataDepoWd = DepoWd::where('username', strtolower($request->username))->where('jenis', 'DP')->where('status', '0')->first();
            // if ($dataDepoWd) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Gagal melakukan deposit'
            //     ], 400);
            // }

            // $dataDepoWd = DepoWd::where('username', strtolower($request->username))->where('jenis', 'DP')->where('status', '1')->first();
            // if (!$dataDepoWd) {
            //     Member::where('username', strtolower($request->username))
            //         ->update([
            //             'status' => '9',
            //             'is_notnew' => true,
            //         ]);
            // }

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["username"] = strtolower($data["username"]);
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
            // $validator = Validator::make($request->all(), [
            //     'username' => 'required|max:50',
            //     'amount' => 'required|numeric',
            //     'bank' => 'required|max:100',
            //     'mbank' => 'required|max:100',
            //     'mnamarek' => 'required|max:150',
            //     'mnorek' => 'required|max:30',
            //     'balance' => 'required|numeric',
            //     'referral' => 'nullable',
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(['errors' => $validator->errors()->all()], 400);
            // }

            // $dataMember = Member::where('username', strtolower($request->username))->first();
            // if (!$dataMember) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Username tidak terdaftar'
            //     ], 400);
            // }

            // $checkBalance = $this->reqApiBalance($request->username);
            // if ($checkBalance["balance"] < $request->amount) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Balance tidak cukup'
            //     ], 400);
            // }
            // if ($checkBalance["error"]["id"] !== 0) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => $checkBalance["error"]["msg"]
            //     ], 400);
            // }

            // $dataDepoWd = DepoWd::where('username', strtolower($request->username))->where('jenis', 'WD')->where('status', '0')->first();

            // if ($dataDepoWd) {
            //     return response()->json([
            //         'status' => 'Fail',
            //         'message' => 'Gagal melakukan withdrawal'
            //     ], 400);
            // }

            /* Request API check transaction */
            $txnid = $this->generateTxnid('W');

            /* Request Ke Database Internal */
            $data = $request->all();
            $data["username"] = strtolower($data["username"]);
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

                $maxAttempts9720 = 10;
                $attempt9720 = 0;
                while ($resultsApi["error"]["id"] === 9720 && $attempt9720 < $maxAttempts9720) {
                    sleep(6);
                    $resultsApi = $this->requestApi('withdraw', $dataAPI);
                    $attempt9720++;
                }

                $maxAttempts4404 = 10;
                $attempt4404 = 0;
                while ($resultsApi["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
                    $txnid = $this->generateTxnid('W');
                    $data["txnId"] = $txnid;
                    $resultsApi = $this->requestApi('withdraw', $dataAPI);
                    if ($resultsApi["error"]["id"] === 0) {
                        DepoWd::where('id', $dataWD->id)->update([
                            "txnid" => $txnid
                        ]);
                    }
                    $attempt4404++;
                }

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

    function generateTxnid($jenis)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        if ($jenis == 'D') {
            $length = 17;
        } else {
            $length = 10;
        }

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }

    public function getHistoryDepoWd(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;
        $data = DepoWd::where('username', $username)
            ->select('id', 'username', 'balance', 'amount', 'jenis', 'status', 'updated_at')
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

    public function getBalance(Request $request, $username)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $username = $request->username;

        $data = $this->reqApiBalance($username);

        if ($data["error"]["id"] === 0) {
            $results = [
                "username" => $data["username"],
                // "balance" => $data["balance"] + $this->saldoBerjalan($username),
                "balance" => $data["balance"],
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

    public function getTransactions()
    {
        $transactions = Transactions::select('transactions.id', 'transactions.transactionid', 'transactions.username', 'transaction_status.status', 'transaction_status.id as statusid')
            ->join('transaction_status', function ($join) {
                $join->on('transaction_status.trans_id', '=', 'transactions.id')
                    ->whereRaw('transaction_status.created_at = (SELECT MAX(created_at) FROM transaction_status WHERE trans_id = transactions.id)');
            })
            ->where('transaction_status.status', 'Running')
            ->orWhere('transaction_status.status', 'Rollback')
            ->orderByDesc('transaction_status.created_at')
            ->orderBy('transaction_status.urutan')
            ->orderByDesc('transactions.created_at')
            ->get();

        // Mengubah status jika status adalah 'Rollback'
        $transactions->map(function ($transaction) {
            if ($transaction->status === 'Rollback') {
                $transaction->status = 'Running';
            }
            return $transaction;
        });

        return $transactions;
    }

    public function getTransactionAll()
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

    public function deleteTransactions()
    {
        try {
            Transactions::query()->delete();
            TransactionStatus::query()->delete();
            TransactionSaldo::query()->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 400);
        }
    }

    public function getDataOutstanding(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        // $dataTransactions = Transactions::select('id')->get();
        // $lastStatuses = TransactionStatus::select('trans_id', DB::raw('MAX(urutan) as max_urutan'))
        //     ->whereIn('trans_id', $dataTransactions->pluck('id'))
        //     ->groupBy('trans_id');

        // $lastStatuses = TransactionStatus::select('transaction_status.trans_id', 'transaction_status.status', 'transaction_saldo.amount')
        //     ->joinSub($lastStatuses, 'last_status', function ($join) {
        //         $join->on('transaction_status.trans_id', '=', 'last_status.trans_id')
        //             ->on('transaction_status.urutan', '=', 'last_status.max_urutan');
        //     })
        //     ->join('transaction_saldo', 'transaction_saldo.transtatus_id', '=', 'transaction_status.id')
        //     ->where('transaction_status.status', 'Running')
        //     ->get();

        $lastStatuses = Outstanding::select('id AS trans_id', 'status', 'amount')->get();

        return $lastStatuses;
    }


    public function getHistoryGame(Request $request, $username, $portfolio, $startDate, $endDate)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }
        $data = [
            'username' => $username,
            'portfolio' => $portfolio,
            'startDate' => $startDate . 'T00:00:00.540Z',
            'endDate' => $endDate . 'T23:59:59.540Z',
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')

        ];
        $apiUrl = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-modify-date.aspx';

        $response = Http::post($apiUrl, $data);
        $results = $response->json();

        if ($results["error"] != 0) {

            $results = $results['result'];
            foreach ($results as &$d) {
                $d['orderTime'] = Carbon::parse($d['orderTime'])->addHours(11)->toDateTimeString();
                $d['modifyDate'] = Carbon::parse($d['modifyDate'])->addHours(11)->toDateTimeString();
                $d['settleTime'] = Carbon::parse($d['settleTime'])->addHours(11)->toDateTimeString();
                $d['winLostDate'] = Carbon::parse($d['winLostDate'])->addHours(11)->toDateTimeString();
            }
        }


        return $results;
    }

    public function getHistoryGameById(Request $request)
    {
        $validasiBearer = $this->validasiBearer($request);
        if ($validasiBearer !== true) {
            return $validasiBearer;
        }

        $refNos = $request->refNos;
        $portfolio = $request->portfolio;

        $data = [
            'refNos' => $refNos,
            'portfolio' => $portfolio,
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')
        ];
        $apiUrl = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-refnos.aspx';

        $response = Http::post($apiUrl, $data);
        return $response->json();
    }

    private function validasiBearer(Request $request)
    {
        $token = $request->header('utilitiesgenerate');
        $expectedToken = env('UTILITIES_GENERATE');
        // return 'token header: ' . $token . ' || token env: ' . $expectedToken;

        if ($token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        return true;
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
}
