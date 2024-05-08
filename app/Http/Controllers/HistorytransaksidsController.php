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
        // $dataDepoWd = DepoWd::where('')
        $data = [];
        return view('historytransaksids.index', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function transaksilama()
    {
        return view('historytransaksids.transaksi_lama', [
            'title' => 'History Transaksi Lama',
            'totalnote' => 0,
        ]);
    }
}
