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
        $data = $this->requestApi('master');
        if ($data["status"] == 'success') {
            $data = $data["data"];
        }

        return view('bankds.index', [
            'title' => 'Bank Setting',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function storemaster(Request $request)
    {
        $validatedData = $request->validate([
            'bnkmstrxyxyx' => 'required',
            'urllogoxxyx' => 'required',
            'statusxyxyy' => 'required',
        ]);
        $validatedData["statusxyxyy"] = intval($validatedData["statusxyxyy"]);
        $apiUrl = 'https://back-staging.bosraka.com/banks/master';

        $response = Http::post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect()->route('bankds')->with('success', 'Master Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    private function requestApi($endpoint)
    {
        $url = 'https://back-staging.bosraka.com/banks/' . $endpoint;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $responseData = $response->json();
        }

        return $responseData;
    }

    public function setbankmaster()
    {

        return view('bankds.bankmaster_edit', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function addbankmaster()
    {

        return view('bankds.bankmaster_add', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function setgroupbank()
    {

        return view('bankds.groupbank_edit', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function addgroupbank()
    {

        return view('bankds.groupbank_add', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function setbank()
    {

        return view('bankds.rekbank_edit', [
            'title' => 'Add & Set Bank',
            'totalnote' => 0,
        ]);
    }

    public function addbank()
    {

        return view('bankds.rekbank_add', [
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
