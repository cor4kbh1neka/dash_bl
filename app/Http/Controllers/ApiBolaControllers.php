<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bettings;
use App\Models\BettingStatus;
use App\Models\BettingTransactions;
use Illuminate\Support\Facades\Http;


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



        $saldo = $this->apiGetBelance($request);

        $response = [
            "AccountName" => $saldo['username'],
            "Balance" => $saldo['balance'],
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
            'TransactionId' => 'required',
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
            return $this->errorResponse($request->Username, 5003);
        }

        $saldo = $this->apiGetBelance($request);
        if ($saldo["balance"] < $request->Amount) {
            return $this->errorResponse($request->Username, 5);
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
        $dataBetting = Bettings::where('transfercode', $request->TransferCode)->first();
        if (!$dataBetting) {
            return $this->errorResponse($request->Username, 6);
        }

        $lastStatus = BettingStatus::where('bet_id', $dataBetting->id)->orderBy('created_at', 'DESC')->first();

        if ($lastStatus->status === 'Cancel') {
            $lastRunningStatus = BettingStatus::where('bet_id', $dataBetting->id)->where('status', 'Running')->orderBy('created_at', 'DESC')->first();

            if ($lastRunningStatus) {
                $dataTransactions = BettingTransactions::where('betstatus_id', $lastRunningStatus->id)->first();

                $txnid = $this->generateTxnid('W', 10);
                $request->merge(['Amount' => $dataTransactions->amount]);
                $WdSaldo = $this->withdraw($request, $txnid);

                if ($WdSaldo["error"]["id"] === 4404) {
                    return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
                }

                if ($WdSaldo["error"]["id"] === 9720) {
                    return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
                }

                if ($WdSaldo["error"]["id"] === 0) {
                    $createBetting = $dataBetting;

                    $crteateStatusBetting = $this->updateBetStatus($createBetting->id, 'Rollback');


                    if ($crteateStatusBetting) {
                        $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "W", $request->Amount);

                        if ($bettingTransaction) {
                            $saldo = $this->apiGetBelance($request);
                            return response()->json([
                                'AccountName' => $request->Username,
                                'Balance' => $saldo['balance'],
                                'ErrorCode' => 0,
                                'ErrorMessage' => 'No Error'
                            ])->header('Content-Type', 'application/json; charset=UTF-8');
                        }
                    }
                }
            }
            return $this->errorResponse($request->Username, 6);
        } else if ($lastStatus->status === 'Settled') {

            $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Rollback');
            $dataLstRunning = BettingStatus::where('bet_id', $dataBetting->id)->where('status', 'Running')->first();
            $dataLstSettle = BettingStatus::where('bet_id', $dataBetting->id)->where('status', 'Settled')->first();

            if ($crteateStatusBetting) {
                /* Rollback Settle */
                $dtStatusBetting = $dataLstSettle;
                $dataTransactions = BettingTransactions::where('betstatus_id', $dtStatusBetting->id)->first();
                $txnid = $this->generateTxnid('W', 17);

                $request->merge(['Amount' => $dataTransactions->amount]);
                $addTransactions = $this->withdraw($request, $txnid);

                if ($addTransactions["error"]["id"] === 4404) {
                    return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                }

                if ($addTransactions["error"]["id"] === 9720) {
                    return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                }

                if ($addTransactions["error"]["id"] === 0) {
                    $this->createbetTransaction($crteateStatusBetting->id, $txnid, 'W', $request->Amount);
                }

                /* Make Running Status */
                $historyLastRunning = BettingTransactions::where('betstatus_id', $dataLstRunning->id)->first();
                $txnid = $this->generateTxnid('R', 12);

                $bettingRollback = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "D", $historyLastRunning->amount);

                if ($bettingRollback) {
                    $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $historyLastRunning->txnid, "W", $historyLastRunning->amount);

                    if ($bettingTransaction) {
                        $saldo = $this->apiGetBelance($request);
                        return response()->json([
                            'AccountName' => $request->Username,
                            'Balance' => $saldo['balance'],
                            'ErrorCode' => 0,
                            'ErrorMessage' => 'No Error'
                        ])->header('Content-Type', 'application/json; charset=UTF-8');
                    }
                }
            } else {
                return $this->errorResponse($request->Username, 6);
            }
        } else if ($lastStatus->status === 'Rollback') {
            return $this->errorResponse($request->Username, 2003);
        } else {
            $this->errorResponse($request->Username, 6);
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
        $dataStatusBetting = BettingStatus::where('bet_id', $dataBetting->id)->get();

        if ($lastStatus->status != 'Cancel') {
            $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Cancel');

            if ($crteateStatusBetting) {
                foreach ($dataStatusBetting as $index => $dtStatusBetting) {
                    $dataTransactions = BettingTransactions::where('betstatus_id', $dtStatusBetting->id)->first();
                    $jenis = $dataTransactions->jenis == 'W' ? 'D' : 'W';
                    $rangeNumber = $jenis == 'D' ? 17 : 10;
                    $txnid = $this->generateTxnid($jenis, $rangeNumber);

                    if ($dataTransactions->jenis == 'W') {
                        $request->merge(['WinLoss' => $dataTransactions->amount]);
                        $addTransactions = $this->deposit($request, $txnid);
                    } else {
                        $request->merge(['Amount' => $dataTransactions->amount]);
                        $addTransactions = $this->withdraw($request, $txnid);
                    }
                    if ($addTransactions["error"]["id"] === 4404) {
                        return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                    }

                    if ($addTransactions["error"]["id"] === 9720) {
                        return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                    }

                    if ($addTransactions["error"]["id"] === 0) {
                        $amount = $jenis == 'D' ? $request->WinLoss : $request->Amount;
                        $this->createbetTransaction($crteateStatusBetting->id, $txnid, $jenis, $amount);
                    }
                }
            }

            $saldo = $this->apiGetBelance($request);
            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => $saldo['balance'],
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
            $DpSaldo = $this->deposit($request, $txnid);

            if ($DpSaldo["error"]["id"] === 4404) {
                return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            }

            if ($DpSaldo["error"]["id"] === 9720) {
                return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            }

            if ($DpSaldo["error"]["id"] === 0) {
                $crteateStatusBetting = $this->updateBetStatus($dataBetting->id, 'Settled');
                if ($crteateStatusBetting) {
                    $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "D", $request->WinLoss);
                    if ($bettingTransaction) {
                        $saldo = $this->apiGetBelance($request);
                        return response()->json([
                            'AccountName' => $request->Username,
                            'Balance' => $saldo['balance'],
                            'ErrorCode' => 0,
                            'ErrorMessage' => 'No Error'
                        ])->header('Content-Type', 'application/json; charset=UTF-8');
                    }
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
    private function setBetting(Request $request)
    {
        $txnid = $this->generateTxnid('W', 10);
        $WdSaldo = $this->withdraw($request, $txnid);

        if ($WdSaldo["error"]["id"] === 4404) {
            return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
        }

        if ($WdSaldo["error"]["id"] === 9720) {
            return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
        }

        if ($WdSaldo["error"]["id"] === 0) {
            $createBetting = $this->createBetting($request);

            $crteateStatusBetting = $this->updateBetStatus($createBetting->id, 'Running');


            if ($crteateStatusBetting) {
                $bettingTransaction = $this->createbetTransaction($crteateStatusBetting->id, $txnid, "W", $request->Amount);

                if ($bettingTransaction) {
                    $saldo = $this->apiGetBelance($request);
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Balance' => $saldo['balance'],
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
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

    private function createbetTransaction($betstatus_id, $txnid, $jenis, $amount)
    {
        $results = BettingTransactions::create([
            "betstatus_id" => $betstatus_id,
            "txnid" => $txnid,
            "jenis" => $jenis,
            "amount" => $amount
        ]);
        return $results;
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
            $errorMessage = 'Error';
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
