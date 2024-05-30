<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\DepoWd;
use App\Models\HistoryTransaksi;
use App\Models\Xdpwd;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\Transactions;
use App\Models\Xtrans;
use App\Models\Balance;
use App\Models\ReferralDepo1;
use App\Models\ReferralDepo2;
use App\Models\ReferralDepo3;
use App\Models\ReferralDepo4;
use App\Models\ReferralDepo5;
use App\Models\winlossDay;
use App\Models\winlossMonth;
use App\Models\winlossYear;
use App\Models\Xreferral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// date_default_timezone_set('Asia/Jakarta');

class DepoWdController extends Controller
{
    private function reqApiBalance($username)
    {
        $dataApiCheckBalance = [
            "Username" => $username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];

        return $this->requestApi('get-player-balance', $dataApiCheckBalance);
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
                        $jenis = 'DP';
                        $req = $this->requestApi('deposit', $dataAPI);
                    } elseif ($result->jenis == 'WDM') {
                        $jenis = 'WD';
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
                        DepoWd::where('id', $result->id)->delete();
                        return redirect()->route('manualds')->with([
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $request->jenis,
                            'errorCode' => 500,
                            'message' => 'Gagal melakukan transaksi!'
                        ]);
                    } else if ($req["error"]["id"] === 0) {
                        $processBalance = $this->processBalance($result->username, $jenis, $result->amount);

                        /* Create History */
                        $keterangan = $result->jenis == 'DPM' ? 'deposit' : 'withdraw';
                        $debit = $result->jenis == 'WDM' ? $result->amount : 0;
                        $kredit = $result->jenis == 'DPM' ? $result->amount : 0;
                        $this->addDataHistory($result->username, $txnid, '', $keterangan, 'manual', $debit, $kredit, $processBalance["balance"]);

                        /* Win Loss WD */
                        $this->addDataWinLoss($result->username, $result->amount, $keterangan);

                        return redirect()->route('manualds')->with([
                            'title' => 'Proses Manual',
                            'totalnote' => 0,
                            'jenis' => $result->jenis,
                            'errorCode' => 200,
                            'message' => 'Transaksi berhasil!'
                        ]);
                    }
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

    public function approve(Request $request, $jenis)
    {
        try {
            $data = $request->all();
            $ids = [];

            foreach ($data as $key => $value) {
                if (strpos($key, 'myCheckbox-') === 0) {
                    $uuid = substr($key, strlen('myCheckbox-'));
                    $ids[] = $uuid;
                }
            }

            foreach ($ids as $id) {
                $dataDepo = DepoWd::where('id', $id)->where('status', 0)->first();
                $txnid = $this->generateTxnid('D');

                if ($dataDepo) {
                    $updateDepo = $dataDepo->update(['status' => 1, 'approved_by' => Auth::user()->username]);
                    if ($updateDepo) {

                        /* Cek Data Member */
                        $dataMember = MemberAktif::where('username', $dataDepo->username)->first();
                        if (!$dataMember) {
                            $dataMember = Member::where('username', $dataDepo->username)->first();
                        }

                        if ($dataMember) {
                            /* Create Depo Downline */
                            if ($dataMember->referral !== null && $dataMember->referral !== '') {
                                $this->addDataDepoDownline($dataMember->referral, $dataDepo->username, $dataDepo->amount);
                            }

                            /* Create Member Aktif */
                            if ($dataMember->referral != '' || $dataMember->referral != null) {
                                $dataMemberAktif = MemberAktif::where('username', $dataDepo->username)->first();
                                if (!$dataMemberAktif) {
                                    MemberAktif::create([
                                        'username' => $dataDepo->username,
                                        'referral' => $dataMember->referral
                                    ]);
                                }
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
                                        'sum_dp' => 0,
                                        'groupbank' => $dataDepo->groupbank
                                    ]);
                                } else {
                                    Xtrans::create([
                                        'bank' => $dataDepo->bank,
                                        'username' => $dataDepo->username,
                                        'count_wd' => 0,
                                        'sum_wd' => 0,
                                        'count_dp' => 1,
                                        'sum_dp' => $dataDepo->amount,
                                        'groupbank' => $dataDepo->groupbank
                                    ]);
                                }
                            } else {
                                if ($dataDepo->jenis == 'WD') {
                                    $dataXtrans->increment('count_wd');
                                    $dataXtrans->increment('sum_wd', $dataDepo->amount);
                                    $dataXtrans->save();
                                } else {
                                    $dataXtrans->increment('count_dp');
                                    $dataXtrans->increment('sum_dp', $dataDepo->amount);
                                    $dataXtrans->save();
                                }
                            }

                            if ($dataDepo->jenis !== 'WD') {
                                $dataAPI = [
                                    "Username" => $dataDepo->username,
                                    "TxnId" => $txnid,
                                    "Amount" => $dataDepo->amount,
                                    "CompanyKey" => env('COMPANY_KEY'),
                                    "ServerId" => env('SERVERID')
                                ];

                                if ($dataDepo->jenis == 'DP') {
                                    $resultsApi = $this->requestApi('deposit', $dataAPI);

                                    if ($resultsApi["error"]["id"] === 0) {
                                        $prosesBalance = $this->processBalance($dataDepo->username, 'DP', $dataDepo->amount);

                                        /* Create History Depo */
                                        $this->addDataHistory($dataDepo->username, $txnid, '', 'deposit', 'deposit', 0, $dataDepo->amount, $prosesBalance["balance"]);

                                        /* Win Loss DP */
                                        $this->addDataWinLoss($dataDepo->username, $dataDepo->amount, "deposit");

                                        /* Delete Notif */
                                        $dataToDelete = Xdpwd::where('username', $dataDepo->username)->where('jenis', $dataDepo->jenis)->first();
                                        if ($dataToDelete) {
                                            $dataToDelete->delete();
                                        }

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

                                    $maxAttempts4404 = 10;
                                    $attempt4404 = 0;
                                    while ($resultsApi["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
                                        $txnid = $this->generateTxnid('D');
                                        $data["txnId"] = $txnid;
                                        $resultsApi = $this->requestApi('deposit', $dataAPI);
                                        if ($resultsApi["error"]["id"] === 0) {
                                            $dataDepo->update([
                                                "txnid" => $txnid
                                            ]);

                                            /* Proses Deduct Saldo */
                                            $prosesBalance = $this->processBalance($dataDepo->username, 'DP', $dataDepo->amount);

                                            /* Create History Depo */
                                            $this->addDataHistory($dataDepo->username, $txnid, '', 'deposit', 'deposit', 0, $dataDepo->amount, $prosesBalance["balance"]);
                                        }
                                        $attempt4404++;
                                    }
                                } else {
                                    return back()->withInput()->with('error', 'Gagal melakukan transaksi!');
                                }

                                if ($resultsApi["error"]["id"] !== 0) {
                                    DepoWd::where('id', $id)->update(['status' => 0, 'approved_by' => null]);
                                    return back()->withInput()->with('error', $resultsApi["error"]["msg"]);
                                }
                            } else {
                                /* Delete Notif */
                                $dataToDelete = Xdpwd::where('username', $dataDepo->username)->where('jenis', $dataDepo->jenis)->first();
                                if ($dataToDelete) {
                                    $dataToDelete->delete();
                                }

                                /* Create History WD */
                                $balance = Balance::where('username', $dataDepo->username)->first()->amount;
                                $this->addDataHistory($dataDepo->username, $txnid, '', 'withdraw', 'withdraw', $dataDepo->amount, 0, $balance);

                                /* Win Loss WD */
                                $this->addDataWinLoss($dataDepo->username, $dataDepo->amount, "withdraw");
                            }
                        }
                    }
                }
            }

            if ($jenis == 'DP') {
                $url = '/depositds';
                $message = 'Deposit berhasil diproses';
            } else {
                $url = '/withdrawds';
                $message = 'Withdrawal berhasil diproses';
            }

            return redirect($url)->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, $jenis)
    {
        try {
            $data = $request->all();
            $ids = [];

            foreach ($data as $key => $value) {
                if (strpos($key, 'myCheckbox-') === 0) {
                    $uuid = substr($key, strlen('myCheckbox-'));
                    $ids[] = $uuid;
                }
            }

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
                    return back()->withInput()->with('error', 'Data tidak ditemukan');
                }

                if ($updateStatusTransaction->jenis == 'WD') {

                    $txnid = $this->generateTxnid('D');

                    /* Proses Pengembalian Dana*/
                    $dataAPI = [
                        "Username" => $updateStatusTransaction->username,
                        "TxnId" => $txnid,
                        "Amount" => $updateStatusTransaction->amount,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];
                    $resultsApi = $this->requestApi('deposit', $dataAPI);

                    if ($resultsApi["error"]["id"] === 0) {
                        $this->processBalance($updateStatusTransaction->username, 'DP', $updateStatusTransaction->amount);
                    }

                    $maxAttempts4404 = 10;
                    $attempt4404 = 0;
                    while ($resultsApi["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
                        $txnid = $this->generateTxnid('W');
                        $data["txnId"] = $txnid;
                        $resultsApi = $this->requestApi('withdraw', $dataAPI);
                        if ($resultsApi["error"]["id"] === 0) {
                            $updateStatusTransaction->update([
                                "txnid" => $txnid
                            ]);
                        }
                        $attempt4404++;
                    }
                }
            }

            if ($jenis == 'DP') {
                $url = '/depositds';
                $message = 'Deposit berhasil dibatalkan';
            } else {
                $url = '/withdrawds';
                $message = 'Withdrawal berhasil dibatalkan';
            }
            return redirect($url)->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
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

    private function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        // if ($response->successful()) {
        $responseData = $response->json();
        // } else {
        //     $statusCode = $response->status();
        //     $errorMessage = $response->body();
        //     $responseData = "Error: $statusCode - $errorMessage";
        // }

        return $responseData;
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
            // $apiBalance = $this->reqApiBalance($username)["balance"];
            // $saldoBerjalan = $this->saldoBerjalan($username);

            // return $apiBalance + $saldoBerjalan;
            $dataBalance = Balance::where('username', $username)->first();
            if ($dataBalance) {
                $amount = $dataBalance->amount;
            } else {
                $amount = 0;
            }
            return $amount;
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


    public function processBalance($username, $jenis, $amount)
    {
        try {
            DB::beginTransaction();

            $balance = Balance::where('username', $username)->lockForUpdate()->first();

            if (!$balance) {
                throw new \Exception('Saldo pengguna tidak ditemukan.');
            }

            if ($jenis == 'DP') {
                $balance->amount += $amount;
            } else {
                $balance->amount -= $amount;
            }

            $balance->save();

            DB::commit();
            return [
                "status" => 'success',
                "balance" => $balance->amount
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                "status" => 'fail',
                "balance" => 0
            ];
        }
    }

    public function getNotifikasi()
    {
        return [
            'dataDepo' => Xdpwd::select('id')->where('jenis', 'DP')->where('isnotif', 0)->get(),
            'dataWd' => Xdpwd::select('id')->where('jenis', 'WD')->where('isnotif', 0)->get(),
            'countDP' => Xdpwd::where('jenis', 'DP')->count(),
            'countWD' => Xdpwd::where('jenis', 'WD')->count()
        ];
    }

    public function getDataDepoWd()
    {
        /* ga dipake cumba buat cek doang */
        return DepoWd::get();
    }

    public function updateNotifikasi($id)
    {
        $dataXdpwd = Xdpwd::where('id', $id)->first();
        if ($dataXdpwd) {
            $dataXdpwd->update([
                'isnotif' => 1
            ]);
        }
        return ['status' => 'success'];
    }

    public function getDataXdpwd()
    {
        return Xdpwd::get();
    }

    public function addDataWinLoss($username, $amount, $jenis)
    {

        /* W/L harian */
        $winLoss = WinlossDay::where('username', $username)->where('day', date("d"))->where('month', date("m"))->where('year', date("Y"))->first();
        if (!$winLoss) {
            WinlossDay::create([
                'username' => $username,
                'count' => 1,
                'day' => date("d"),
                'month' => date("m"),
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLoss->increment('count');
            if ($jenis == 'deposit') {
                $winLoss->increment('deposit', $amount);
            } else {
                $winLoss->increment('withdraw', $amount);
            }
        }

        /* W/L bulanan */
        $winLossMonth = winlossMonth::where('username', $username)->where('month', date("m"))->where('year', date("Y"))->first();
        if (!$winLossMonth) {
            winlossMonth::create([
                'username' => $username,
                'count' => 1,
                'month' => date("m"),
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLossMonth->increment('count');
            if ($jenis == 'deposit') {
                $winLossMonth->increment('deposit', $amount);
            } else {
                $winLossMonth->increment('withdraw', $amount);
            }
        }

        /* W/L tahunan */
        $winLossYear = winlossYear::where('username', $username)->where('year', date("Y"))->first();
        if (!$winLossYear) {
            winlossYear::create([
                'username' => $username,
                'count' => 1,
                'year' => date("Y"),
                'deposit' => $jenis == 'deposit' ? $amount : 0,
                'withdraw' => $jenis == 'withdraw' ? $amount : 0
            ]);
        } else {
            $winLossYear->increment('count');
            if ($jenis == 'deposit') {
                $winLossYear->increment('deposit', $amount);
            } else {
                $winLossYear->increment('withdraw', $amount);
            }
        }

        return;
    }

    public function addDataDepoDownline($referral, $username, $amount)
    {
        $dataReferral = [
            'upline' => $referral,
            'downline' => $username,
            'amount' => $amount
        ];

        if (preg_match('/^[a-e]/i', $referral)) {
            $dataRef = ReferralDepo1::where('downline', $username)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
            if (!$dataRef) {
                ReferralDepo1::create($dataReferral);
            } else {
                $dataRef->increment('amount', $amount);
            }
        } elseif (preg_match('/^[f-j]/i', $referral)) {
            $dataRef = ReferralDepo2::where('downline', $username)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
            if (!$dataRef) {
                ReferralDepo2::create($dataReferral);
            } else {
                $dataRef->increment('amount', $amount);
            }
        } elseif (preg_match('/^[k-o]/i', $referral)) {
            $dataRef = ReferralDepo3::where('downline', $username)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
            if (!$dataRef) {
                ReferralDepo3::create($dataReferral);
            } else {
                $dataRef->increment('amount', $amount);
            }
        } elseif (preg_match('/^[p-t]/i', $referral)) {
            $dataRef = ReferralDepo4::where('downline', $username)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
            if (!$dataRef) {
                ReferralDepo4::create($dataReferral);
            } else {
                $dataRef->increment('amount', $amount);
            }
        } elseif (preg_match('/^[u-z]/i', $referral)) {
            $dataRef = ReferralDepo5::where('downline', $username)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();
            if (!$dataRef) {
                ReferralDepo5::create($dataReferral);
            } else {
                $dataRef->increment('amount', $amount);
            }
        }

        return;
    }

    public function addDataHistory($username, $txnid, $refno, $keterangan, $status, $debit, $kredit, $balance)
    {
        HistoryTransaksi::create([
            'username' => $username,
            'invoice' => $txnid,
            'refno' => $refno,
            'keterangan' => $keterangan,
            'status' => $status,
            'debit' => $debit,
            'kredit' => $kredit,
            'balance' => $balance
        ]);

        return;
    }
}
