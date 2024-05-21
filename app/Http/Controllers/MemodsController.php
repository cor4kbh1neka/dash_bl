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
        $response = Http::get('https://back-staging.bosraka.com/memo');
        $results = [];
        if ($response->json()['status'] !== 'fail') {
            $results = $response->json()["data"];
        }
        dd($results);
        return view('memods.delivered_memo', [
            'title' => 'Delivered',
            'totalnote' => 0,
            'data' => $results
        ]);
    }

    public function readdelivered($id)
    {
        $response = Http::get('https://back-staging.bosraka.com/memo');
        $results = $response->json()["data"];
        $result = collect($results)->where('idmemo', $id)->toArray();
        $result = array_values($result);

        return view('memods.delivered_read', [
            'title' => 'Delivered',
            'totalnote' => 0,
            'data' => $result[0]
        ]);
    }

    public function storememo(Request $request)
    {
        $validatedData = $request->validate([
            'statustype' => 'required',
            'statuspriority' => 'required',
            'subject' => 'required',
            'memo' => 'required',
        ]);

        $validatedData["statustype"] = intval($validatedData["statustype"]);
        $validatedData["statuspriority"] = intval($validatedData["statuspriority"]);
        $apiUrl = 'https://back-staging.bosraka.com/memo';
        $response = Http::post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect('/memods/delivered')->with('success', 'Memo berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function delete($id)
    {
        $response = Http::delete('https://back-staging.bosraka.com/memo/' . $id);
        if ($response->successful()) {
            return redirect('/memods/delivered')->with('success', 'Memo berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }
}
