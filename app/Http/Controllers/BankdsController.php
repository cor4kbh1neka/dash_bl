<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BankdsController extends Controller
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
        return view('bankds.index', [
            'title' => 'Bank Setting',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function setbankmaster()
    {

        return view('bankds.setbankmaster', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function addbank()
    {

        return view('bankds.addbank', [
            'title' => 'Add & Set Bank',
            'totalnote' => 0,
        ]);
    }

    public function listmaster()
    {

        return view('bankds.listmaster', [
            'title' => 'List Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function listgroup()
    {

        return view('bankds.listgroup', [
            'title' => 'List Group Bank',
            'totalnote' => 0,
        ]);
    }

    public function listbank()
    {

        return view('bankds.listbank', [
            'title' => 'List Bank',
            'totalnote' => 0,
        ]);
    }
}
