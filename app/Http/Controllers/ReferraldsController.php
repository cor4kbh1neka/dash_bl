<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReferraldsController extends Controller
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
        return view('referralds.index', [
            'title' => 'Referral',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function downlinedetail()
    {

        return view('referralds.detail_downline', [
            'title' => 'Downline Detail',
            'totalnote' => 0,
        ]);
    }

    public function bonusreferral()
    {

        return view('referralds.referral_downline', [
            'title' => 'Bonus Referral',
            'totalnote' => 0,
        ]);
    }
}
