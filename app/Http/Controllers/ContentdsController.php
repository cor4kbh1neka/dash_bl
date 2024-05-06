<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ContentdsController extends Controller
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
        return view('contentds.index', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function promo()
    {
        return view('contentds.promo', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function promoadd()
    {
        return view('contentds.promo_add', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function promoedit()
    {
        return view('contentds.promo_edit', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function slider()
    {
        return view('contentds.slider', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function slideradd()
    {
        return view('contentds.slider_add', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function slideredit()
    {
        return view('contentds.slider_edit', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function link()
    {
        return view('contentds.link', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function linkedit()
    {
        return view('contentds.link_edit', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function socialmedia()
    {
        return view('contentds.socialmedia', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function socialmediaedit()
    {
        return view('contentds.socialmedia_edit', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }
}
