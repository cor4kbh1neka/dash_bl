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
    public function Bonus()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Bonuss'], 200);
    }

    public function Cancel()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Cancel'], 200);
    }

    public function Deduct()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Deduct'], 200);
    }

    public function GetBalance()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/GetBalance'], 200);
    }

    public function Rollback()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Rollback'], 200);
    }

    public function Settle()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/Settle'], 200);
    }

    public function GetBetStatus()
    {
        return response()->json(['message' => 'Bet settled successfully', 'redirect_url' => '/GetBetStatus'], 200);
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
}
