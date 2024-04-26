<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MemodsController extends Controller
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

        return view('memods.index', [
            'title' => 'Memo',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function viewinbox()
    {

        return view('memods.inbox_memo', [
            'title' => 'Inbox',
            'totalnote' => 0,
        ]);
    }

    public function readinbox()
    {

        return view('memods.inbox_read', [
            'title' => 'Read Inbox',
            'totalnote' => 0,
        ]);
    }

    public function archiveinbox()
    {

        return view('memods.inbox_archive', [
            'title' => 'Archive Inbox',
            'totalnote' => 0,
        ]);
    }

    public function delivered()
    {

        return view('memods.delivered_memo', [
            'title' => 'Delivered',
            'totalnote' => 0,
        ]);
    }

    public function readdelivered()
    {

        return view('memods.delivered_read', [
            'title' => 'Delivered',
            'totalnote' => 0,
        ]);
    }

    public function storememo(Request $request)
    {
    }
}
