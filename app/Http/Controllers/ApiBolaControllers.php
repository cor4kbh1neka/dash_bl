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
        #Decode request
        $data = [
            'CompanyKey' => $request->CompanyKey, //The CompanyKey is error => 4
            'Username' => $request->Username, // Username is empty => 3 //The member is not exist => 1
            'Amount' => $request->Amount,    //Not enough balance => 5
            'BonusTime' => $request->BonusTime,
            'IsGameProviderPromotion' => $request->IsGameProviderPromotion,
            'ProductType' => $request->ProductType,
            'GameType' => $request->GameType,
            'TransferCode' => $request->TransferCode,
            'TransactionId"' => $request->TransactionId,
            'GameId' => $request->GameId,
            'Gpid' => $request->Gpid
            // error lain // Internal Error => 7
        ];

        #Validation
        /* Validasi Company */
        $modelCompany = Companys::where('companykey', $request->CompanyKey)->first();
        if (!$modelCompany) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 4,
                'ErrorMessage' => 'CompanyKey Error'
            ], 400);
        }

        /* Validasi username is empty */
        if (!$request->Username) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 3,
                'ErrorMessage' => 'Username empty'
            ], 400);
        }

        /* Validasi Players member exsis or not */
        $modelCompany = Players::where('username', $request->Username)->first();
        if (!$modelCompany) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 4,
                'ErrorMessage' => 'Member not exist'
            ], 400);
        }


        /* Validasi Alldata */
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
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 7,
                'ErrorMessage' => 'Internal Error'
            ], 400);
        } else {
            try {
                $dataAddSaldo = [
                    "Username" => $request->Username,
                    "TxnId" => $this->generateRandomString(),
                    "Amount" => $request->Amount,
                    "CompanyKey" => $request->CompanyKey,
                    "ServerId" => 'YY-TEST'
                ];

                $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
                //Jalanakan ulang perintah add saldo jika muncul error /* Transaction Has Made With Same Id */
                while ($addSaldo["error"]["id"] === 4404 || $addSaldo["error"]["msg"] === 'Transaction Has Made With Same Id') {
                    $dataAddSaldo['TxnId'] = $this->generateRandomString();
                    $addSaldo = $this->requestApi('deposit', $dataAddSaldo);
                }
                if ($addSaldo["error"]["id"] === 0 || $addSaldo["error"]["msg"] === "No Error") {
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Belance' => $addSaldo["balance"],
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ]);
                }

                return response()->json(['errors' => [$addSaldo["error"]["msg"]]], 400);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
            }
        }

        # If encounter error, return error code and not null balance
        # Connect to database
        # Get Balance from database and return
    }

    public function Deduct(Request $request)
    {
        return '/Deduct';
    }

    public function Cancel(Request $request)
    {
        return '/Cancel';
    }

    public function GetBalance(Request $request)
    {
        $request->merge([
            'CompanyKey' => 'C441C721B2214E658A6D2A72C41D2063',
            'Username' => 'Player_C_001',
            'ProductType' => 1,
            'GameType' => 1,
            'Gpid' => -1,
        ]);

        # Decode request
        $data = [
            'CompanyKey' => $request->CompanyKey,
            'Username' => $request->Username,
            'ProductType' => $request->ProductType,
            'GameType' => $request->GameType,
            'Gpid' => $request->Gpid,
        ];

        # Validation companyKey and other data
        /* Validasi Company */
        $modelCompany = Companys::where('companykey', $request->CompanyKey)->first();
        if (!$modelCompany) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 4,
                'ErrorMessage' => 'CompanyKey Error'
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        }

        /* Validasi username is empty */
        if (!$request->Username) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 3,
                'ErrorMessage' => 'Username empty'
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        }

        /* Validasi Players member exsis or not */
        $modelCompany = Players::where('username', $request->Username)->first();
        if (!$modelCompany) {
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 4,
                'ErrorMessage' => 'Member not exist'
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        }

        /* Validasi Alldata */
        $validator = Validator::make($request->all(), [
            'CompanyKey' => 'required',
            'Username' => 'required|regex:/^[a-zA-Z0-9_]{6,20}$/',
            'ProductType' => 'required|integer',
            'GameType' => 'required|integer',
            'Gpid' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            return response()->json([
                'AccountName' => $request->Username,
                'Belance' => 0,
                'ErrorCode' => 7,
                'ErrorMessage' => 'Internal Error'
            ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
        } else {
            try {
                $dataGetBalance = [
                    'Username' => $request->Username,
                    'CompanyKey' => $request->CompanyKey,
                    'ServerId' => $request->serverId,
                ];
                $getBalance = $this->requestApi('get-player-balance', $dataGetBalance);

                if ($getBalance["error"]["id"] === 0 || $getBalance["error"]["msg"] === "No Error") {
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Belance' => $getBalance["balance"],
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }

                return response()->json([
                    'AccountName' => $request->Username,
                    'Belance' => 0,
                    'ErrorCode' => 99,
                    'ErrorMessage' => $getBalance["error"]["msg"]
                ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
            } catch (\Exception $e) {
                return response()->json([
                    'AccountName' => $request->Username,
                    'Belance' => 0,
                    'ErrorCode' => 99,
                    'ErrorMessage' => $e->getMessage()
                ], 400)->header('Content-Type', 'application/json; charset=UTF-8');
            }
        }


        # If encounter error, return error code and not null balance
        # Connect to database
        # Get Balance from database and return


        // $data = [
        //     'Username' => $request->Username,
        //     'CompanyKey' => $request->CompanyKey,
        //     'ServerId' => $request->serverId,
        // ];
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json; charset=UTF-8',
        // ])->post('https://ex-api-demo-yy.568win.com/web-root/restricted/player/get-player-balance.aspx', $data);

        // if ($response->successful()) {

        //     $responseData = $response->json();
        //     dd($responseData);
        // } else {
        //     $statusCode = $response->status();
        //     $errorMessage = $response->body();
        //     $responseData = "Error: $statusCode - $errorMessage";
        // }

        // return $responseData;
    }

    public function Rollback(Request $request)
    {
        return '/Rollback';
    }

    public function Settle(Request $request)
    {
        return '/Settle';
    }

    public function GetBetStatus(Request $request)
    {
        return '/GetBetStatus';
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
}
