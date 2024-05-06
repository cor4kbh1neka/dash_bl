<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HistorytransaksidsController extends Controller
{
    public function index()
    {
        $data = [
            [
                'id' => '1',
                'nama' => 'Waantos',
                'alamat' => 'Pekanbaru',
                'notelp' => '0778007711',
                'tgllhir' => '12-09-1996',
                'tempatlahir' => 'sukajadi'
            ]
        ];
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
