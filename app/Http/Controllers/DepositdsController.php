<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DepositdsController extends Controller
{
    public function index()
    {
        if (Route::is('depositds')) {
            $jenis = 'DP';
        } elseif (Route::is('withdrawds')) {
            $jenis = 'WD';
        }

        $dataCountDepoWd = DepoWd::select('bank', DB::raw('count(id) as count'))
            ->where('status', 0)
            ->where('jenis', $jenis)
            ->groupBy('bank')
            ->get();

        /* Data master bank */
        $dataBank = $this->getApiMasterBank();
        $arrayData = [];
        foreach ($dataBank as &$item1) {
            $item1['count'] = 0;

            foreach ($dataCountDepoWd as $item2) {
                if ($item1['bnkmstrxyxyx'] === $item2->bank) {
                    $item1['count'] = $item2->count;
                    break;
                }
            }
        }

        /* History transkasi */
        $dataTransaksi = DepoWd::whereIn('status', [1, 2])->where('jenis', $jenis)->orderBy('updated_at', 'DESC')->get();

        /* Data depo wd */
        $dataDepoWd = DepoWd::with('member:username,status')->where('status', 0)->where('jenis', $jenis)->orderBy('created_at', 'ASC')->get();

        /* View depo / wd */
        if ($jenis == 'WD') {
            $path = 'withdrawds.index';
            $title = 'Withdrawal';
        } else {
            $path = 'depositds.index';
            $title = 'Deposit';
        }

        return view($path, [
            'title' => $title,
            'totalnote' => 0,
            'data' => $dataDepoWd,
            'dataTransaksi' => $dataTransaksi,
            'dataBank' => $dataBank
        ]);
    }

    private function getApiMasterBank()
    {
        // "status" => "success"
        $response = Http::get('https://back-staging.bosraka.com/banks/master');
        $response = $response->json();

        if ($response['status'] == 'success') {
            $response = $response['data'];
        } else {
            $response = [];
        }

        return $response;
    }

    public function getDataHistory($username, $jenis)
    {
        if ($jenis == "ALL") {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        } else {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->where('jenis', $jenis)->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        }


        return $dataHistory;
    }
}
