<?php

namespace App\Http\Controllers;

use App\Models\Outstanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OutstandingdsController extends Controller
{
    public function index(Request $request, $userid = "")
    {
        $username = $request->input('username');

        $getDataOuts = Outstanding::get();
        $dataOuts = $getDataOuts;

        if ($username) {
            $dataOuts = $dataOuts->where('username', $username);
        }

        $dataOuts = $dataOuts->groupBy('username')->map(function ($group) {
            $totalAmount = $group->sum('amount');
            $count = $group->count();
            return [
                'username' => $group->first()['username'],
                'totalAmount' => $totalAmount,
                'count' => $count,
            ];
        })->values();

        $countOuts = $dataOuts->count();

        if ($userid != '') {
            $dataOtstandingDetail = $getDataOuts->where('username', $userid);
        } else {
            $dataOtstandingDetail = [];
        }

        return view('outstandingds.index', [
            'title' => 'Member Outstanding',
            'data' => $dataOuts,
            'totalnote' => 0,
            'username' => $username,
            'countOuts' => $countOuts,
            'dataouts' => $dataOtstandingDetail
            // 'isList' => $isList
        ]);
    }

    private function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            // $statusCode = $response->status();
            // $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }
}
