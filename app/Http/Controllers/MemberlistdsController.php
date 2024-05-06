<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MemberlistdsController extends Controller
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
        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function update()
    {

        return view('memberlistds.update', [
            'title' => 'Edit Member',
            'totalnote' => 0,
        ]);
    }

    public function winloseyear()
    {

        return view('memberlistds.winlose_year', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
        ]);
    }

    public function winlosemonth()
    {

        return view('memberlistds.winlose_month', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
        ]);
    }

    public function winloseday()
    {

        return view('memberlistds.winlose_day', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
        ]);
    }
}
