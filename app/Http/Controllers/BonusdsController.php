<?php

namespace App\Http\Controllers;

use App\Models\BonusPengecualian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BonusdsController extends Controller
{
    public function index(Request $request)
    {
        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari');
        $gabunghingga = $request->input('gabunghingga');
        $pengecualian = $request->input('kecuali');

        $dataBonusPengecualian = BonusPengecualian::get();
        $data = [];
        return view('bonusds.index', [
            'title' => 'Cashback dan Rollingan',
            'data' => $data,
            'dataBonusPengecualian' => $dataBonusPengecualian,
            'totalnote' => 0,
            'bonus' => $bonus,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'pengecualian' => $pengecualian
        ]);
    }
}
