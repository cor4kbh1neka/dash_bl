<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AnalyticsdsController extends Controller
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
        return view('analyticsds.index', [
            'title' => 'Analytics',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function sitemap()
    {
        return view('analyticsds.sitemap', [
            'title' => 'Analytics',
            'totalnote' => 0,
        ]);
    }
}
