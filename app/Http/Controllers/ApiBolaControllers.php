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
        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataSaldo = [
            "Username" => $request->Username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $saldo = $this->requestApi('get-player-balance', $dataSaldo);

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
        return '';
    }

    public function Deduct(Request $request)
    {
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

        // $cekBetting = Bettings::where('transfercode', $request->TransferCode);
        // if($dataBetting) {

        // }



    }

    private function setBetting(Request $request)
    {
        $txnid = $this->generateTxnid('D', 17);
        $dataSaldo = [
            "Username" => $request->Username,
            "txnId" => $txnid,
            "IsFullAmount" => false,
            "Amount" => $request->Amount,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $WdSaldo = $this->requestApi('withdraw', $dataSaldo);

        if ($WdSaldo["error"]["id"] === 4404) {
            return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
        }

        if ($WdSaldo["error"]["id"] === 0) {
            $createBetting = Bettings::create([
                "transfercode" => $request->TransferCode,
                "username" => $request->Username,
                "amount" => $request->Amount
            ]);
            if (!$createBetting) {
                return response()->json(['error' => 'Failed to create betting'], 500);
            }

            $crteateStatusBetting = BettingStatus::create([
                "bet_id" => $createBetting->id,
                "status" => 'Running'
            ]);
            if ($crteateStatusBetting) {
                BettingTransactions::create([
                    "betstatus_id" => $crteateStatusBetting->id,
                    "txnid" => $txnid,
                    "jenis" => "W",
                    "amount" => $request->Amount
                ]);

                return response()->json([
                    'AccountName' => $request->Username,
                    // 'Balance' => $getBalance["balance"],
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }
        }
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
        } else {
            $errorMessage = '';
        }


        return response()->json([
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    function generateTxnid($jenis, $length = 17)
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

    public function Cancel()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Cancel'], 200);
    }


    public function Rollback()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Rollback'], 200);
    }

    public function Settle()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Settle'], 200);
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
}
