<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Agents;
use App\Models\Transactions;
use App\Models\BettingStatus;
use Illuminate\Support\Facades\Http;

class ApiBolaControllers extends Controller
{
    public function Bonus(Request $request)
    {
        try {
            /* Validation */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            $validator = Validator::make($request->all(), [
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/',
                'Amount' => 'required|numeric',
                'BonusTime' => 'required',
                'IsGameProviderPromotion' => 'required|boolean',
                'ProductType' => 'required|integer',
                'GameType' => 'required|integer',
                'TransferCode' => 'required|numeric',
                'TransactionId' => 'required|numeric',
                'GameId' => 'required|integer',
                'Gpid' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            /* InjectSaldo */
            // $InjectSaldo = $this->depositAmount($request);
            // return $InjectSaldo;
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
        return;
    }

    private function depositAmount($dataAddSaldo, $jenis)
    {
        $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
        $txnId = $this->generateRandomString('D');

        /* Retry adding balance if error "Transaction Has Made With Same Id" */
        $maxRetries = 3;
        $retryCount = 0;
        while (($addSaldo["error"]["id"] === 4404 || $addSaldo["error"]["msg"] === 'Transaction Has Made With Same Id') && $retryCount < $maxRetries) {
            $txnId = $this->generateRandomString('D');
            $addSaldo['TxnId'] = $txnId;
            $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
            $retryCount++;
        }

        if ($addSaldo["error"]["id"] === 0 || $addSaldo["error"]["msg"] === "No Error") {

            $UpdateSettleStatus = BettingStatus::where('username', $dataAddSaldo['Username'])->where('transfercode', $dataAddSaldo['TransferCode'])->where('status', 'Running')->update([
                'status' => 'Settled',
            ]);

            $dataTransaction = [
                'txnid' => $txnId,
                'transfercode' => $dataAddSaldo['TransferCode'],
                'username' => $dataAddSaldo['Username'],
                'jenis' => $jenis,
                'amount' => $dataAddSaldo['Amount'],
            ];
            if ($UpdateSettleStatus > 0) {
                $this->createTransaction($dataTransaction);

                return [
                    'AccountName' => $dataAddSaldo['Username'],
                    'Balance' => $addSaldo["balance"],
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ];
            }

            return ['errors' => [$addSaldo["error"]["msg"]]];
        }

        return ['errors' => [$addSaldo["error"]["msg"]]];
    }

    public function Deduct(Request $request)
    {
        try {
            /* Validation Username & Company Key */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            /* Validation Requiremnt */
            $validator = Validator::make($request->all(), [
                'Amount' => 'required|numeric|min:0',
                'TransferCode' => 'required',
                'TransactionId' => 'required',
                'BetTime' => 'required',
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            /* Cehck internal status Betting */
            $bettingStatus = BettingStatus::where('transfercode', $request->TransferCode)
                ->where('username', $request->Username)->first();

            if ($bettingStatus) {
                return $this->errorResponse($request->Username, 5003, 'Bet With Same RefNo Exists');
            }

            /* Check Status Betting */
            $betStatusCheckResult = $this->checkBetStatus($request);
            if ($betStatusCheckResult !== true) {
                return $betStatusCheckResult;
            }

            /* Check Balance Have Saldo Or Not */
            $balanceCheckResult = $this->checkBalance($request);
            if ($balanceCheckResult !== true) {
                return $balanceCheckResult;
            }

            /* Create betting */
            $data = [
                'transfercode' => $request->TransferCode,
                'username' => $request->Username,
                'status' => 'Running',
            ];
            $withdrawData = BettingStatus::create($data);

            if ($withdrawData) {
                /* Deduct Saldo */
                $withdrawResult = $this->withdrawAmount($request, 'WD');
                return $withdrawResult;
            }
            return $this->errorResponse($request->Username, 5003, 'Bet With Same RefNo Exists');
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
    }

    private function checkBalance(Request $request)
    {
        $dataGetBalance = [
            'Username' => $request->Username,
            'CompanyKey' => $request->CompanyKey,
            'ServerId' => 'YY-TEST',
        ];
        $getBalance = $this->requestApi('get-player-balance', $dataGetBalance);

        if ($getBalance["error"]["id"] !== 0 && $getBalance["error"]["msg"] !== "No Error") {
            return $this->errorResponse($request->Username, 5, 'Not enough balance');
        }

        if ($getBalance["balance"] < $request->Amount) {
            return $this->errorResponse($request->Username, 5, 'Not enough balance');
        }

        return true;
    }

    private function checkBetStatus(Request $request)
    {
        /* check transfercode pada table betting */
        $dataBetting = $this->checkDataBetting($request->TransferCode);
        if ($dataBetting !== true) {
            return $dataBetting;
        }

        /* check transfercode pada table betting */
        $dataWD = $this->getTransactionByTransferCode($request->TransferCode, 'WD');

        /* Check API transaction status */
        $dataGetBetStatus = [
            'TxnId' => $dataWD != null ? $dataWD->txnid : $request->TransferCode,
            'CompanyKey' => env('COMPANY_KEY'),
            'ServerId' => 'YY-TEST',
        ];
        $getBetStatus = $this->requestApi('check-transaction-status', $dataGetBetStatus);

        if ($getBetStatus["error"]["id"] === 0 || $getBetStatus["error"]["msg"] === "No Error") {
            return $this->errorResponse($request->Username, 5003, 'Bet With Same RefNo Exists');
        }

        return true;
    }

    private function getTransactionByTransferCode($transferCode, $jenis)
    {
        $dataWD = Transactions::where('transfercode', $transferCode)->where('jenis', $jenis)->first();
        return $dataWD;
    }

    private function withdrawAmount(Request $request, $jenis)
    {
        $txnId = $this->generateRandomString('W');

        if ($jenis === 'WC') {
            $AmountDepo =   Transactions::where('transfercode', $request->TransferCode)->where('jenis', 'WD')->where('username', $request->Username)->first();
            $AmountWD =   Transactions::where('transfercode', $request->TransferCode)->where('jenis', 'DS')->where('username', $request->Username)->first();
        }

        $dataWithdraw = [
            'Username' => $request->Username,
            'txnId' => $txnId,
            'IsFullAmount' => false,
            'Amount' => $request->Amount,
            'CompanyKey' => $request->CompanyKey,
            'ServerId' => 'YY-TEST',
        ];
        dd($dataWithdraw);
        // Request API for withdrawal
        $getBalance = $this->requestApi('withdraw', $dataWithdraw);

        // Retry adding balance if error "Transaction Has Made With Same Id"
        $maxRetries = 3;
        $retryCount = 0;
        while (($getBalance["error"]["id"] === 4404 || $getBalance["error"]["msg"] === 'Transaction Has Made With Same Id') && $retryCount < $maxRetries) {
            $txnId = $this->generateRandomString('W');
            $dataWithdraw['TxnId'] = $txnId;
            $getBalance = $this->requestApi('withdraw', $dataWithdraw);
            $retryCount++;
        }
        // Check for successful withdrawal
        if ($getBalance["error"]["id"] === 0 || $getBalance["error"]["msg"] === "No Error") {

            /* Update status cancel jika $jenis = WC (withdraw cancel) */
            if ($jenis === 'WC') {
                BettingStatus::where('transfercode', $request->TransferCode)
                    ->where('username', $request->Username)
                    ->whereIn('status', ['Running', 'Settled'])
                    ->update([
                        'status' => 'Void'
                    ]);
            }

            /* create Trnsaction */
            $dataTransaction = [
                'txnid' => $txnId,
                'transfercode' => $request->TransactionId,
                'username' => $request->Username,
                'jenis' => $jenis,
                'amount' => $request->Amount,
            ];
            $this->createTransaction($dataTransaction);

            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => $getBalance["balance"],
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ])->header('Content-Type', 'application/json; charset=UTF-8');
        }

        return $this->errorResponse($request->Username, 99, $getBalance["error"]["msg"]);
    }

    private function createTransaction($data)
    {
        return Transactions::create($data);
    }

    private function errorResponse($username, $errorCode, $errorMessage)
    {
        return response()->json([
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function Cancel(Request $request)
    {
        try {
            /* Validation Username & Company Key */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            /* Validation Requiremnt */
            $validator = Validator::make($request->all(), [
                'TransferCode' => 'required',
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            /* Cehck internal status Betting */
            $bettingStatus = BettingStatus::where('transfercode', $request->TransferCode)
                ->where('username', $request->Username)->first();

            if ($bettingStatus->status === 'Running' || $bettingStatus->status === 'Settled') {
                $withdrawResult = $this->withdrawAmount($request, 'WC');
                return $withdrawResult;
            }

            // /* Check Status Betting */
            // $betStatusCheckResult = $this->checkBetStatus($request);
            // if ($betStatusCheckResult !== true) {
            //     return $betStatusCheckResult;
            // }

            // /* Check Balance Have Saldo Or Not */
            // $balanceCheckResult = $this->checkBalance($request);
            // if ($balanceCheckResult !== true) {
            //     return $balanceCheckResult;
            // }

            /* Create betting */
            // $data = [
            //     'transfercode' => $request->TransferCode,
            //     'username' => $request->Username,
            //     'status' => 'Running',
            // ];
            // $withdrawData = BettingStatus::create($data);

            // if ($withdrawData) {
            //     /* Deduct Saldo */
            //     $withdrawResult = $this->withdrawAmount($request, 'WD');
            //     return $withdrawResult;
            // }
            return $this->errorResponse($request->Username, 5003, 'Bet With Same RefNo Exists');
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
    }

    public function GetBalance(Request $request)
    {
        try {
            $this->updateCompanyKey();
            /* Validation Username & Company Key */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            /* Validation Require */
            $validator = Validator::make($request->all(), [
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            /* GetBalance */
            $balance = $this->requestApiForBalance($request);

            if ($balance["error"]["id"] === 0 || $balance["error"]["msg"] === "No Error") {
                return response()->json([
                    'AccountName' => $request->Username,
                    'Balance' => $balance["balance"],
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }

            return $this->errorResponse($request->Username, 99, $balance["error"]["msg"]);
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
    }

    private function requestApiForBalance(Request $request)
    {
        $dataGetBalance = [
            'Username' => $request->Username,
            'CompanyKey' => $request->CompanyKey,
            'TransactionId' => $request->TransactionId,
        ];

        return $this->requestApi('get-player-balance', $dataGetBalance);
    }

    private function validateUserAndCompany(Request $request)
    {
        $company = env('COMPANY_KEY') == $request->CompanyKey;
        if (!$company) {
            return $this->errorResponse($request->Username, 4, 'CompanyKey Error');
        }

        if (!$request->Username) {
            return $this->errorResponse($request->Username, 3, 'Username empty');
        }

        // $user = Players::where('username', $request->Username)->first();
        // if (!$user) {
        //     return $this->errorResponse($request->Username, 4, 'Member not exist');
        // }

        return true;
    }

    public function Rollback(Request $request)
    {
        return '/Rollback';
    }

    public function Settle(Request $request)
    {
        try {
            /* Validation Username & Company Key */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            /* Validation Require */
            $validator = Validator::make($request->all(), [
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            /* check Data Betting Must Have Running Status */
            $checkDataBetting = BettingStatus::where('transfercode', $request->TransferCode)
                ->where('username', $request->Username)
                ->first();
            if ($checkDataBetting) {
                if ($checkDataBetting->status === 'Settled') {
                    return $this->errorResponse($request->Username, 2001, 'Bet Already Settled');
                }
            }

            if (!$checkDataBetting) {
                return $this->errorResponse($request->Username, 6, 'Bet not exists');
            }

            /* Add Saldo */
            $dataAddSaldo = [
                'Username' => $request->Username,
                'TxnId' => $this->generateRandomString('D'),
                'TransferCode' => $request->TransferCode,
                'Amount' => $request->WinLoss,
                'CompanyKey' => $request->CompanyKey,
                'ServerId' => $request->ServerId
            ];
            $addSaldo = $this->depositAmount($dataAddSaldo, 'DS');

            return $addSaldo;
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
    }

    public function GetBetStatus(Request $request)
    {
        try {
            /* Validation */
            $validationResult = $this->validateUserAndCompany($request);
            if ($validationResult !== true) {
                return $validationResult;
            }

            $validator = Validator::make($request->all(), [
                'CompanyKey' => 'required',
                'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/',
                'ProductType' => 'required|integer',
                'GameType' => 'required|integer',
                'TransferCode' => 'required|integer',
                'TransactionId' => 'required|integer',
                'Gpid' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            /* Check status betting data internal */
            $dataBetting = $this->checkDataBetting($request->TransferCode);

            if ($dataBetting !== true) {
                return $dataBetting;
            }

            /* BetStatus */
            $betStatus = $this->requestApiForBetStatus($request);

            if ($betStatus["error"]["id"] === 0 || $betStatus["error"]["msg"] === "No Error") {
                return response()->json([
                    'TransferCode' => $request->TransferCode,
                    'TransactionId' => $request->TransactionId,
                    "Status" => "running", /* Saat Ada Pemasangan Maka Status nya running */
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            } elseif ($betStatus["error"]["id"] === 4602 || $betStatus["error"]["msg"] === "No Transaction Found") {
                return response()->json([
                    'TransferCode' => $request->TransferCode,
                    'TransactionId' => $request->TransactionId,
                    'ErrorCode' => 6,
                    'ErrorMessage' => 'Bet not exists' /* Saat Tidak Ada Transaksi */
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }

            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => 0,
                'ErrorCode' => 99,
                'ErrorMessage' => $betStatus["error"]["msg"]
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        } catch (\Exception $e) {
            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => 0,
                'ErrorCode' => 99,
                'ErrorMessage' => $e->getMessage()
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        }
    }

    private function requestApiForBetStatus(Request $request)
    {
        $dataWD = $this->getTransactionByTransferCode($request->TransactionId, 'WD');
        $txnid = $dataWD != null ?  $dataWD->txnid : $request->TransactionId;

        $dataGetBetStatus = [
            'TxnId' => $txnid,
            'CompanyKey' => $request->CompanyKey,
            'ServerId' => 'YY-TEST',
        ];

        return $this->requestApi('check-transaction-status', $dataGetBetStatus);
    }

    public function ReturnStake(Request $request)
    {
        return '/ReturnStake';
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

    function generateRandomString($jenis, $length = 17)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }

    private function updateCompanyKey()
    {
        $affectedRows = Agents::where('CompanyKey', '!=', env('COMPANY_KEY'))
            ->update(['CompanyKey' => env('COMPANY_KEY')]);

        return response()->json([
            'message' => $affectedRows . ' baris berhasil diperbarui.',
        ], 200);
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
        if (!$request->header('Authorization')) {
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
            'Content-Type' => 'application/json; charset=UTF-8',
            'Authorization' => 'Bearer ' .  env('BEARER_TOKEN'),
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

    private function checkDataBetting($transfercode)
    {
        $dataBetting = BettingStatus::where('transfercode', $transfercode)->first();

        if ($dataBetting) {
            if ($dataBetting->status === 'Running' || $dataBetting->status === 'Settled') {
                return response()->json([
                    'TransferCode' => $transfercode,
                    'TransactionId' => $transfercode,
                    "Status" => $dataBetting->status, /* Saat Ada Pemasangan Maka Status nya running */
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            } else {
                return $this->errorResponse($dataBetting->username, 5003, 'Bet With Same RefNo Exists');
            }
        }

        return true;
    }
}
