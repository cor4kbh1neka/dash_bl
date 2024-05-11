<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\DepoWd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HistorytransaksidsController extends Controller
{
    public function index()
    {
        $dataDepoWd = DepoWd::where('username', 'poorgas321')
            ->whereBetween('updated_at', ['2024-04-01', '2024-05-09'])
            ->get();

        $dataApiBetList = $this->getApiBetList();
        if ($dataApiBetList["error"]["id"] !== 0) {
            $dataApiBetList = [];
        }

        // dd($dataApiBetList);

        $data = [];
        return view('historytransaksids.index', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    private function getApiBetList()
    {
        $data = [
            "username" => "abangpoorgas",
            "portfolio" => "SportsBook",
            "startDate" => "2024-04-01T00:00:00.540Z",
            "endDate" => "2024-05-30T23:59:59.540Z",
            "companyKey" => "C441C721B2214E658A6D2A72C41D2063",
            "language" => "en",
            "serverId" => "YY-TEST"
        ];
        $response = Http::post('https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-modify-date.aspx', $data);

        return $response->json();
    }


    public function transaksilama()
    {
        return view('historytransaksids.transaksi_lama', [
            'title' => 'History Transaksi Lama',
            'totalnote' => 0,
        ]);
    }
}
