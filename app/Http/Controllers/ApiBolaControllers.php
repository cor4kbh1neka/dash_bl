<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bettings;
use App\Models\BettingStatus;
use App\Models\BettingTransactions;
use Illuminate\Support\Facades\Http;
use App\Jobs\createWdJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;


class ApiBolaControllers extends Controller
{
    public function GetBalance(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);

        $response = [
            "AccountName" => $request->Username,
            "Balance" => $saldo,
            "ErrorCode" => 0,
            "ErrorMessage" => "No Error"
        ];
        return response()->json($response, 200);
    }

    public function GetBetStatus(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            'TransferCode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataBetting = Bettings::where('transfercode', $request->TransferCode)->first();
        if (!$dataBetting) {
            return $this->errorResponse($request->Username, 6);
        }

        $statusBetting = BettingStatus::where('bet_id', $dataBetting->id)->orderBy('created_at', 'DESC')->first();

        if ($statusBetting->status == 'Rollback' || $statusBetting->status == 'Running') {
            $status = 'Running';
        } else if ($statusBetting->status == 'Cancel') {
            $status = 'Void';
        } else {
            $status = $statusBetting->status;
        }


        return response()->json([
            'TransferCode' => $request->TransferCode,
            'TransactionId' => $request->TransactionId,
            "Status" => $status,
            'ErrorCode' => 0,
            'ErrorMessage' => 'No Error'
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function Deduct(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "Amount" => 'required',
            "TransferCode" => 'required',
            "TransactionId" => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $cekBetting = Bettings::where('transfercode', $request->TransferCode)->first();
        if ($cekBetting) {

            if ($request->ProductType != 3) {
                return $this->errorResponse($request->Username, 5003);
            } else {
                $cetLastStatus = BettingStatus::where('bet_id', $cekBetting->id)->orderBy('created_at', 'DESC')->first();
                if ($cetLastStatus->status == 'Running') {
                    $totalBetting = BettingTransactions::where('betstatus_id', $cetLastStatus->id)->sum('amount');
                    if ($request->Amount > $totalBetting) {
                        return $this->setBetting($request);
                    } else {
                        return $this->errorResponse($request->Username, 7);
                    }
                } else {
                    return $this->errorResponse($request->Username, 5003);
                }
            }
        }

        return $this->setBetting($request);
    }

    public function Settle(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "WinLoss" => 'required',
            "TransferCode" => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        return $this->setSettle($request);
    }

    public function Cancel(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "IsCancelAll" => 'required',
            "TransferCode" => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        return $this->setCancel($request);
    }

    public function Rollback(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "TransferCode" => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        return $this->setRollback($request);
    }










    /* ====================== Validasi SBO ======================= */
    private function validasiSBO(Request $request)
    {
        if ($request->Username == '') {
            return $this->errorResponse($request->Username, 3);
        }

        if ($request->Username != 'Player_C_002') {
            return $this->errorResponse($request->Username, 1);
        }

        if ($request->CompanyKey != env('COMPANY_KEY')) {
            return $this->errorResponse($request->Username, 4);
        }

        return true;
    }

    /* ====================== Rollback ======================= */
    private function setRollback(Request $request)
    {
        set_time_limit(60);
        try {
            $dataBetting = Bettings::where('transfercode', $request->TransferCode)->first();
            if (!$dataBetting) {
                return $this->errorResponse($request->Username, 6);
            }

            $lastStatus = BettingStatus::where('bet_id', $dataBetting->id)->orderBy('created_at', 'DESC')->first();

            if ($lastStatus->status === 'Cancel') {
                $lastRunningStatus = BettingStatus::where('bet_id', $dataBetting->id)->where('status', 'Running')->orderBy('created_at', 'DESC')->first();

                if ($lastRunningStatus) {
                    if ($request->ProductType == 3) {
                        $totalAmount = BettingTransactions::where('betstatus_id', $lastRunningStatus->id)->sum('amount');
                    } else {
                        $dataTransactions = BettingTransactions::where('betstatus_id', $lastRunningStatus->id)->first();
                        $totalAmount = $dataTransactions->amount;
                    }
                    $txnid = $this->generateTxnid('W', 10);
                    // $request->merge(['Amount' => $dataTransactions->amount]);

                    // $WdSaldo = $this->withdraw($request, $txnid);

                    // if ($WdSaldo["error"]["id"] === 9720) {
                    //     $WdSaldo = $this->requestWitdraw9720($request, $txnid);
                    // }

                    // if ($WdSaldo["error"]["id"] === 4404) {
                    //     return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
                    // }

                    $createBetting = $dataBetting;
                    $crteateStatusBetting = $this->updateBetStatus($createBetting->id, 'Rollback');

                    if ($crteateStatusBetting) {
                        $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "W", $totalAmount, 1);

                        if ($bettingTransaction) {
                            $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);
                            return response()->json([
                                'AccountName' => $request->Username,
                                'Balance' => $saldo,
                                'ErrorCode' => 0,
                                'ErrorMessage' => 'No Error'
                            ])->header('Content-Type', 'application/json; charset=UTF-8');
                        }
                    }
                    return 'error $bettingTransaction : ' . $bettingTransaction;
                }
                return 'error $lastRunningStatus : ' . $lastRunningStatus;
            } else if ($lastStatus->status === 'Settled') {

                $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Rollback');

                $dataLstSettle = BettingStatus::where('bet_id', $dataBetting->id)->where('status', 'Settled')->orderBy('created_at', 'DESC')->first();
                $dataLstRunning = BettingStatus::where('bet_id', $dataBetting->id)->where('id', '!=', $dataLstSettle->id)->where('created_at', '<',  $dataLstSettle->created_at)->orderBy('created_at', 'DESC')->first();

                /* Make Running Status */
                if ($crteateStatusBetting) {
                    /* Rollback Settle */
                    $dtStatusBetting = $dataLstSettle;
                    $dataTransactions = BettingTransactions::where('betstatus_id', $dtStatusBetting->id)->first();
                    $txnid = $this->generateTxnid('W', 17);

                    // $request->merge(['Amount' => $dataTransactions->amount]);
                    // $addTransactions = $this->withdraw($request, $txnid);

                    // if ($addTransactions["error"]["id"] === 4501) {
                    //     $dataAllTrans = BettingStatus::with('bettingtransactions')
                    //         ->where('bet_id', $dataBetting->id)
                    //         ->get();
                    //     dd($dataAllTrans);
                    // }

                    // if ($addTransactions["error"]["id"] === 9720) {
                    //     $addTransactions = $this->requestWitdraw9720($request, $txnid);
                    // }

                    // if ($addTransactions["error"]["id"] === 4404) {
                    //     return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                    // }

                    $this->createbetTransaction($crteateStatusBetting->id, $txnid, 'W', $dataTransactions->amount, 1);

                    /* Make Running Status */
                    $historyLastRunning = BettingTransactions::where('betstatus_id', $dataLstRunning->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                    $txnid = $this->generateTxnid('D', 10);
                    $bettingRollback = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "D", $historyLastRunning->amount, 2);

                    if ($bettingRollback) {
                        $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $historyLastRunning->txnid, "W", $historyLastRunning->amount, 3);

                        if ($bettingTransaction) {
                            $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);
                            return response()->json([
                                'AccountName' => $request->Username,
                                'Balance' => $saldo,
                                'ErrorCode' => 0,
                                'ErrorMessage' => 'No Error'
                            ])->header('Content-Type', 'application/json; charset=UTF-8');
                        }
                        return 'error $bettingTransaction : ' . $bettingTransaction;
                    }
                    return 'error $bettingRollback : ' . $bettingRollback;
                } else {
                    return $this->errorResponse($request->Username, 6);
                }
            } else if ($lastStatus->status === 'Rollback') {
                return $this->errorResponse($request->Username, 2003);
            } else {
                $this->errorResponse($request->Username, 6);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan di sini
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }


    /* ====================== Cancel ======================= */
    private function setCancel(Request $request)
    {
        $dataBetting = Bettings::where('transfercode', $request->TransferCode)->first();
        if (!$dataBetting) {
            return $this->errorResponse($request->Username, 6);
        }

        $lastStatus = BettingStatus::where('bet_id', $dataBetting->id)->orderBy('created_at', 'DESC')->first();
        $last2ndStatus = BettingStatus::where('bet_id', $dataBetting->id)->where('id', '!=', $lastStatus->id)->orderBy('created_at', 'DESC')->first();

        if ($lastStatus->status != 'Cancel') {
            $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Cancel');

            if ($crteateStatusBetting) {

                if ($lastStatus->status == 'Settled') {

                    $dataTransactions = BettingTransactions::where('betstatus_id', $lastStatus->id)->first();

                    $jenis = 'W';
                    $rangeNumber = 10;
                    $txnid = $this->generateTxnid($jenis, $rangeNumber);
                    $this->createbetTransaction($crteateStatusBetting->id, $txnid, $jenis, $dataTransactions->amount, 1);

                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3) {
                            $totalAmount = BettingTransactions::where('betstatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = BettingTransactions::where('betstatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                            $totalAmount = $dataTransactions->amount;
                        }

                        $jenis = 'D';
                        $rangeNumber = 17;
                        $txnid = $this->generateTxnid($jenis, $rangeNumber);
                        $this->createbetTransaction($crteateStatusBetting->id, $txnid, $jenis, $totalAmount, 2);
                    }
                } else if ($lastStatus->status == 'Running' || $lastStatus->status == 'Rollback') {
                    if ($request->ProductType == 3) {
                        $totalAmount = BettingTransactions::where('betstatus_id', $lastStatus->id)->sum('amount');
                    } else {
                        $dataTransactions = BettingTransactions::where('betstatus_id', $lastStatus->id)->first();
                        $totalAmount = $dataTransactions->amount;
                    }

                    $jenis = 'D';
                    $rangeNumber = 17;
                    $txnid = $this->generateTxnid($jenis, $rangeNumber);

                    $this->createbetTransaction($crteateStatusBetting->id, $txnid, $jenis, $totalAmount, 1);
                }

                // $dataTransactions = BettingTransactions::where('betstatus_id', $dtStatusBetting->id)->first();
                // $jenis = $dataTransactions->jenis == 'W' ? 'D' : 'W';
                // $rangeNumber = $jenis == 'D' ? 17 : 10;
                // $txnid = $this->generateTxnid($jenis, $rangeNumber);

                // if ($dataTransactions->jenis == 'W') {
                //     $request->merge(['WinLoss' => $dataTransactions->amount]);
                //     $addTransactions = $this->deposit($request, $txnid);
                // } else {
                //     $request->merge(['Amount' => $dataTransactions->amount]);
                //     $addTransactions = $this->withdraw($request, $txnid);
                // }

                // if ($addTransactions["error"]["id"] === 9720) {
                //     $addTransactions = $this->requestWitdraw9720($request, $txnid);
                // }

                // if ($addTransactions["error"]["id"] === 4404) {
                //     return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                // }

                // $this->createbetTransaction($crteateStatusBetting->id, $txnid, $jenis, $dataTransactions->amount);
            }

            $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);
            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => $saldo,
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ])->header('Content-Type', 'application/json; charset=UTF-8');
        } else {
            return $this->errorResponse($request->Username, 2002);
        }
    }

    /* ====================== Settle ======================= */
    private function setSettle(Request $request)
    {
        $dataBetting = Bettings::where('transfercode', $request->TransferCode)->first();
        if (!$dataBetting) {
            return $this->errorResponse($request->Username, 6);
        }

        $dataStatusBet = BettingStatus::where('bet_id', $dataBetting->id)->orderBy('created_at', 'DESC')->first();

        if ($dataStatusBet->status == 'Running' || $dataStatusBet->status == 'Rollback') {
            $txnid = $this->generateTxnid('D', 17);
            // $DpSaldo = $this->deposit($request, $txnid);

            // if ($DpSaldo["error"]["id"] === 9720) {
            //     return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            // }

            // if ($DpSaldo["error"]["id"] === 4404) {
            //     return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            // }

            $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Settled');
            if ($crteateStatusBetting) {
                $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "D", $request->WinLoss, 1);
                if ($bettingTransaction) {
                    $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
            }
        } else if ($dataStatusBet->status == 'Cancel') {
            return $this->errorResponse($request->Username, 2002);
        } else {
            return $this->errorResponse($request->Username, 2001);
        }
    }

    private function deposit(Request $request, $txnid)
    {
        $dataSaldo = [
            "Username" => $request->Username,
            "TxnId" => $txnid,
            "Amount" => $request->WinLoss,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $DpSaldo = $this->requestApi('deposit', $dataSaldo);
        return $DpSaldo;
    }


    /* ====================== Deduct ======================= */
    private function saldoBerjalan(Request $request)
    {
        $allBettingTransaction = $this->getAllTransactions($request);

        $dataAllTransactionsWD = $allBettingTransaction->where('jenis', 'W')->sum('amount');
        $dataAllTransactionsDP = $allBettingTransaction->where('jenis', 'D')->sum('amount');

        $saldoBerjalan = $dataAllTransactionsDP  - $dataAllTransactionsWD;

        return $saldoBerjalan;
    }

    private function requestWitdraw9720(Request $request, $txnid)
    {
        set_time_limit(60);
        sleep(4.5);
        $addTransactions = $this->withdraw($request, $txnid);

        if ($addTransactions["error"]["id"] === 9720) {
            sleep(1.5);
            $addTransactions = $this->withdraw($request, $txnid);
            return $addTransactions;
        }

        return $addTransactions;
    }

    private function setBetting(Request $request)
    {
        $saldoMember = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);

        if ($request->ProductType == 3) {
            $cekBetting = Bettings::where('transfercode', $request->TransferCode)->first();
            if ($cekBetting) {
                $cekLastStatus = BettingStatus::where('bet_id', $cekBetting->id)->first();
                $dataTransactions = BettingTransactions::where('betstatus_id', $cekLastStatus->id)->first();
                $saldoMember = $saldoMember + $dataTransactions->amount;
            }
        }

        if ($saldoMember < $request->Amount) {
            return $this->errorResponse($request->Username, 5);
        }

        $txnid = $this->generateTxnid('W', 10);

        // $WdSaldo = $this->withdraw($request, $txnid);

        // if ($WdSaldo["error"]["id"] === 9720) {
        //     $WdSaldo = $this->requestWitdraw9720($request, $txnid);
        // }

        // if ($WdSaldo["error"]["id"] === 4404) {
        //     return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
        // }
        if ($request->ProductType == 3 && $cekBetting) {
            $createBetting = $cekBetting;
            $crteateStatusBetting = $cekLastStatus;
        } else {
            $createBetting = $this->createBetting($request);
            $crteateStatusBetting = $this->updateBetStatus($createBetting->id, 'Running');
        }

        if ($crteateStatusBetting) {
            if ($request->ProductType == 3 && $cekBetting) {
                $amount = $request->Amount - $dataTransactions->amount;
                $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "W", $amount, 1);
            } else {
                $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "W", $request->Amount, 1);
            }

            if ($bettingTransaction) {
                $saldo = $this->apiGetBelance($request)["balance"] + $this->saldoBerjalan($request);
                return response()->json([
                    'AccountName' => $request->Username,
                    'Balance' => $saldo,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }
        }
    }

    private function withdraw(Request $request, $txnid)
    {
        $dataSaldo = [
            "Username" => $request->Username,
            "txnId" => $txnid,
            "IsFullAmount" => false,
            "Amount" => $request->Amount,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $WdSaldo = $this->requestApi('withdraw', $dataSaldo);
        return $WdSaldo;
    }

    private function createBetting(Request $request)
    {
        $createBetting = Bettings::create([
            "transfercode" => $request->TransferCode,
            "username" => $request->Username,
            "status" => 0
        ]);

        return $createBetting;
    }

    private function updateBetStatus($bet_id, $status)
    {
        $results = BettingStatus::create([
            "bet_id" => $bet_id,
            "status" => $status
        ]);
        return $results;
    }

    private function createbetTransaction($betstatus_id, $txnid, $jenis, $amount, $urutan)
    {
        $results = BettingTransactions::create([
            "betstatus_id" => $betstatus_id,
            "txnid" => $txnid,
            "jenis" => $jenis,
            "amount" => $amount,
            "urutan" => $urutan
        ]);
        return $results;
    }

    private function getAllTransactions(Request $request)
    {
        $username = $request->Username;
        $bettings = Bettings::where('username', $username)->get();
        $bettingTransactions = collect();
        foreach ($bettings as $betting) {
            $transactions = $betting->bettingstatus->flatMap(function ($status) {
                return $status->bettingtransactions;
            });

            $bettingTransactions = $bettingTransactions->concat($transactions);
        }
        return $bettingTransactions;
    }

    /* ====================== GetBelance ======================= */
    private function apiGetBelance(Request $request)
    {
        $dataSaldo = [
            "Username" => $request->Username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $saldo = $this->requestApi('get-player-balance', $dataSaldo);
        return $saldo;
    }



















    function requestApi($endpoint, $data)
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

    private function errorResponse($username, $errorCode)
    {

        if ($errorCode == '0') {
            $errorMessage = 'No Error';
        } else if ($errorCode == '1') {
            $errorMessage = 'Member not exist';
        } else if ($errorCode == '2') {
            $errorMessage = 'Invalid Ip';
        } else if ($errorCode == '3') {
            $errorMessage = 'Username empty';
        } else if ($errorCode == '4') {
            $errorMessage = 'CompanyKey Error';
        } else if ($errorCode == '5') {
            $errorMessage = 'Not enough balance';
        } else if ($errorCode == '6') {
            $errorMessage = 'Bet not exists';
        } else if ($errorCode == '7') {
            $errorMessage = 'Internal Error';
        } else if ($errorCode == '2001') {
            $errorMessage = 'Bet Already Settled';
        } else if ($errorCode == '2002') {
            $errorMessage = 'Bet Already Canceled';
        } else if ($errorCode == '2003') {
            $errorMessage = 'Bet Already Rollback';
        } else if ($errorCode == '5003') {
            $errorMessage = 'Bet With Same RefNo Exists';
        } else if ($errorCode == '5008') {
            $errorMessage = 'Bet Already Returned Stake';
        } else if ($errorCode == '9720') {
            $errorMessage = 'Withdraw request so frequent';
        } else {
            $errorMessage = 'Internal Error';
        }


        return response()->json([
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    function generateTxnid($jenis, $length)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }










    public function Bonus()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Bonuss'], 200);
    }

    public function ReturnStake()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/ReturnStake'], 200);
    }

    public function login($username, $iswap)
    {
        try {
            $dataLogin['Username'] = $username;
            $dataLogin['CompanyKey'] = env('COMPANY_KEY');
            $dataLogin['Portfolio'] = env('PORTFOLIO');
            $dataLogin['IsWapSports'] = $iswap;
            $dataLogin['ServerId'] = "YY-TEST";
            $getLogin = $this->requestApiLogin($dataLogin);
            return $getLogin;
        } catch (\Exception $e) {
            return $this->errorResponse($username, 99, $e->getMessage());
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

    public function register(Request $request)
    {
        $token = $request->bearerToken();
        $expectedToken = env('BEARER_TOKEN');
        if ($token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $data = [
            "Username" => $request->Username,
            "UserGroup" => "c",
            "Agent" => "Agent_C_001",
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

    public function deleteTransactions()
    {
        try {
            Bettings::query()->delete();
            BettingStatus::query()->delete();
            BettingTransactions::query()->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 400);
        }
    }
}
