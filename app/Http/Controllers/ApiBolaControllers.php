<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Companys;
use App\Models\Players;
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
            $InjectSaldo = $this->depostiAmount($request);
            return $InjectSaldo;
        } catch (\Exception $e) {
            return $this->errorResponse($request->Username, 99, $e->getMessage());
        }
        return;
    }

    private function depostiAmount($dataAddSaldo)
    {
        $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
        // Retry adding balance if error "Transaction Has Made With Same Id"
        // while ($addSaldo["error"]["id"] === 4404 || $addSaldo["error"]["msg"] === 'Transaction Has Made With Same Id') {
        //     $dataAddSaldo['TxnId'] = $this->generateRandomString();
        //     $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
        // }

        if ($addSaldo["error"]["id"] === 0 || $addSaldo["error"]["msg"] === "No Error") {
            return response()->json([
                'AccountName' => $dataAddSaldo['Username'],
                'Balance' => $addSaldo["balance"],
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ]);
        }

        return response()->json(['errors' => [$addSaldo["error"]["msg"]]], 400);
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

            /* Check Balance Have Saldo Or Not */
            $balanceCheckResult = $this->checkBalance($request);
            if ($balanceCheckResult !== true) {
                return $balanceCheckResult;
            }

            /* Check Status Betting */
            $betStatusCheckResult = $this->checkBetStatus($request);
            if ($betStatusCheckResult !== true) {
                return $betStatusCheckResult;
            }

            /* Deduct Saldo */
            $withdrawResult = $this->withdrawAmount($request);
            return $withdrawResult;
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
        $dataGetBetStatus = [
            'TxnId' => $request->TransactionId,
            'CompanyKey' => $request->CompanyKey,
            'ServerId' => 'YY-TEST',
        ];
        $getBetStatus = $this->requestApi('check-transaction-status', $dataGetBetStatus);

        if ($getBetStatus["error"]["id"] === 0 || $getBetStatus["error"]["msg"] === "No Error") {
            return $this->errorResponse($request->Username, 5003, 'Bet With Same RefNo Exists');
        }

        return true;
    }

    private function withdrawAmount(Request $request)
    {
        $dataWithdraw = [
            'Username' => $request->Username,
            'txnId' => $request->TransactionId,
            'IsFullAmount' => false,
            'Amount' => $request->Amount,
            'CompanyKey' => $request->CompanyKey,
            'ServerId' => 'YY-TEST',
        ];
        $getBalance = $this->requestApi('withdraw', $dataWithdraw);

        if ($getBalance["error"]["id"] === 0 || $getBalance["error"]["msg"] === "No Error") {
            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => $getBalance["balance"],
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ])->header('Content-Type', 'application/json; charset=UTF-8');
        }

        return $this->errorResponse($request->Username, 99, $getBalance["error"]["msg"]);
    }

    private function errorResponse($username, $errorCode, $errorMessage)
    {
        return response()->json([
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function Cancel(Request $request)
    {
        return '/Cancel';
    }

    public function GetBalance(Request $request)
    {
        try {
            $this->updatePlayers();
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

        $user = Players::where('username', $request->Username)->first();
        if (!$user) {
            return $this->errorResponse($request->Username, 4, 'Member not exist');
        }

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

            /* Inject Saldo */
            $dataAddSaldo = [
                'Username' => $request->Username,
                'TxnId' => $request->TransferCode,
                'Amount' => $request->WinLoss,
                'CompanyKey' => $request->CompanyKey,
                'ServerId' => $request->ServerId
            ];
            $InjectSaldo = $this->depostiAmount($dataAddSaldo);
            return $InjectSaldo;
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
        $dataGetBetStatus = [
            'TxnId' => $request->TransactionId,
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

    function generateRandomString($length = 18)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    private function updatePlayers()
    {
        $affectedRows = Players::where('CompanyKey', '!=', env('COMPANY_KEY'))
            ->update(['CompanyKey' => env('COMPANY_KEY')]);

        return response()->json([
            'message' => $affectedRows . ' baris berhasil diperbarui.',
        ], 200);
    }
}
