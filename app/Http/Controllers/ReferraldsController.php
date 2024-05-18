<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\Referral1;
use App\Models\Referral2;
use App\Models\Referral3;
use App\Models\Referral4;
use App\Models\Referral5;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReferraldsController extends Controller
{
    public function index()
    {


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
