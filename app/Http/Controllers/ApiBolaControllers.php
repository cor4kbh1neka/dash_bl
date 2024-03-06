<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiBolaControllers extends Controller
{
    public function Bonus(Request $request)
    {
        // $data = [
        //     'Username' => $request->username,
        //     'CompanyKey' => $request->companyKey,
        //     'ServerId' => $request->serverId,
        // ];
        // $response = Http::post('https://ex-api-demo-yy.568win.com/web-root/restricted/player/get-player-balance.aspx', $data);

        // if ($response->successful()) {
        //     $responseData = $response->json();
        // } else {
        //     $statusCode = $response->status();
        //     $errorMessage = $response->body();
        //     $responseData = "Error: $statusCode - $errorMessage";
        // }

        // return $responseData;

        return '/Bonus';
    }

    public function Cancel(Request $request)
    {
        return '/Cancel';
    }

    public function Deduct(Request $request)
    {
        return '/Deduct';
    }

    public function GetBalance(Request $request)
    {
        return '/GetBalance';
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
}
