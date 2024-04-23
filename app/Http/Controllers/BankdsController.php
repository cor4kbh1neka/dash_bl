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

    public function changeStatusBank(Request $request, $jenis = '')
    {
        $formData = $request->all();

        $banksData = [];
        if ($jenis == 'WD') {
            foreach ($formData as $key => $value) {
                if (strpos($key, 'myCheckboxWithdraw') !== false) {
                    $bankName = explode('-', $key)[1];

                    $banksData[$bankName] = [
                        'bnkmstrxyxyx' => $formData['bnkmstrxyxyx_' . $bankName],
                        'urllogoxxyx' => $formData['urllogoxxyx_' . $bankName],
                        'wdstatusxyxyy' => $formData['statuswd_' . $bankName],
                        'statusxyxyy' => $formData['statusxyxyy_' . $bankName]

                    ];
                }
            }
        } else {
            foreach ($formData as $key => $value) {
                if (strpos($key, 'myCheckboxDeposit') !== false) {
                    $bankName = explode('-', $key)[1];

                    $banksData[$bankName] = [
                        'bnkmstrxyxyx' => $formData['bnkmstrxyxyx_' . $bankName],
                        'urllogoxxyx' => $formData['urllogoxxyx_' . $bankName],
                        'statusxyxyy' => $formData['statusdepo_' . $bankName],
                        'wdstatusxyxyy' => $formData['wdstatusxyxyy_' . $bankName]

                    ];
                }
            }
        }

        foreach ($banksData as $bankName => $bankData) {
            $bankData["statusxyxyy"] = intval($bankData["statusxyxyy"]);
            $bankData["wdstatusxyxyy"] = intval($bankData["wdstatusxyxyy"]);

            $apiUrl = 'https://back-staging.bosraka.com/banks/master/' . $bankName;

            $response = Http::put($apiUrl, $bankData);
            if (!$response->successful()) {

                return back()->withInput()->with('error', $response->json()["message"]);
            }
        }
        return redirect()->route('bankds')->with('success', 'Status Bank berhasil diupdate');
    }

    public function storemaster(Request $request)
    {
        $validatedData = $request->validate([
            'bnkmstrxyxyx' => 'required',
            'urllogoxxyx' => 'required',
            'statusxyxyy' => 'required',
        ]);
        $validatedData["statusxyxyy"] = intval($validatedData["statusxyxyy"]);
        $validatedData["wdstatusxyxyy"] = intval($validatedData["statusxyxyy"]);
        $validatedData["bnkmstrxyxyx"] = strtolower($validatedData["bnkmstrxyxyx"]);
        $validatedData["urllogoxxyx"] = strtolower($validatedData["urllogoxxyx"]);

        $apiUrl = 'https://back-staging.bosraka.com/banks/master';

        $response = Http::post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect()->route('bankds')->with('success', 'Master Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function storegroupbank(Request $request)
    {
        $validatedData = $request->validate([
            'namegroupxyzt' => 'required',
            'grouptype' => 'required',
            'min_dp' => 'required',
            'max_dp' => 'required',
            'min_wd' => 'required',
            'max_wd' => 'required'

        ]);

        $validatedData["namegroupxyzt"] = strtolower($validatedData["namegroupxyzt"]);
        $validatedData["grouptype"] = intval($validatedData["grouptype"]);
        $validatedData["min_dp"] = intval($validatedData["min_dp"]);
        $validatedData["max_dp"] = intval($validatedData["max_dp"]);
        $validatedData["min_wd"] = intval($validatedData["min_wd"]);
        $validatedData["max_wd"] = intval($validatedData["max_wd"]);

        $apiUrl = 'https://back-staging.bosraka.com/banks/group';

        $response = Http::post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect()->route('listgroup')->with('success', 'Master Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function deletelistgroup($id)
    {
        $response = Http::delete('https://back-staging.bosraka.com/banks/group/' . $id);
        if ($response->successful()) {
            return redirect()->route('listgroup')->with('success', 'List group berhasil dihapus');
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

    public function storebank(Request $request)
    {

        $validatedData = $request->validate([
            'masterbnkxyxt' => 'required',
            'namebankxxyy' => 'required',
            'yyxxmethod' => 'required',
            'xynamarekx' => 'required',
            'norekxyxy' => 'required',
            'barcodexrxr' => 'required',
        ]);

        $validatedData["namegroupxyzt"] = ["nongroup"];
        $validatedData["masterbnkxyxt"] = strtolower($validatedData["masterbnkxyxt"]);
        $validatedData["namebankxxyy"] = strtolower($validatedData["namebankxxyy"]);
        $validatedData["yyxxmethod"] = strtolower($validatedData["yyxxmethod"]);
        $validatedData["xynamarekx"] = strtolower($validatedData["xynamarekx"]);
        $validatedData["norekxyxy"] = strtolower(str_replace("-", "", $validatedData["norekxyxy"]));
        $validatedData["barcodexrxr"] = strtolower($validatedData["barcodexrxr"]);

        $apiUrl = 'https://back-staging.bosraka.com/banks/v2';

        $response = Http::post($apiUrl, $validatedData);
        if ($response->successful()) {
            return redirect('/bankds/listbank')->with('success', 'Set Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
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
        $response = Http::get('https://back-staging.bosraka.com/banks/group');
        $data = $response->json();

        if ($data['status'] == 'success') {
            $data = $data["data"];
            $datadp = array_filter($data, function ($item) {
                return $item['grouptype'] == 1;
            });
            $dataWd = array_filter($data, function ($item) {
                return $item['grouptype'] == 2;
            });
        } else {
            $data = [];
        }

        return view('bankds.listgroup', [
            'title' => 'List Group Bank',
            'totalnote' => 0,
            'data' => $datadp,
            'datawd' => $dataWd
        ]);
    }

    public function updatelistgroup(Request $request, $jenis)
    {
        $formData = $request->all();
        $banksData = [];
        if ($jenis == 'wd') {
            foreach ($formData as $key => $value) {
                if (strpos($key, 'myCheckboxWithdraw') !== false) {
                    $bankName = explode('-', $key)[1];

                    $banksData[$bankName] = [
                        'bnkmstrxyxyx' => $formData['bnkmstrxyxyx_' . $bankName],
                        'urllogoxxyx' => $formData['urllogoxxyx_' . $bankName],
                        'wdstatusxyxyy' => $formData['statuswd_' . $bankName],
                        'statusxyxyy' => $formData['statusxyxyy_' . $bankName]

                    ];
                }
            }
        } else {
            dd($formData);
            foreach ($formData as $key => $value) {
                if (strpos($key, 'myCheckboxDeposit') !== false) {
                    $idGroup = explode('-', $key)[1];
                    $banksData[$idGroup] = [
                        'min_dp' => $formData['min_dp_' . $idGroup],
                        'min_wd' => $formData['min_wd_' . $idGroup],
                        'max_dp' => $formData['max_dp_' . $idGroup],
                        'min_dp' => $formData['min_dp_' . $idGroup]

                    ];
                }
            }
        }

        foreach ($banksData as $bankName => $bankData) {
            $bankData["statusxyxyy"] = intval($bankData["statusxyxyy"]);
            $bankData["wdstatusxyxyy"] = intval($bankData["wdstatusxyxyy"]);

            $apiUrl = 'https://back-staging.bosraka.com/banks/master/' . $bankName;

            $response = Http::put($apiUrl, $bankData);
            if (!$response->successful()) {

                return back()->withInput()->with('error', $response->json()["message"]);
            }
        }
        return redirect()->route('bankds')->with('success', 'Status Bank berhasil diupdate');
    }

    public function listbank()
    {

        return view('bankds.listbank', [
            'title' => 'List Bank',
            'totalnote' => 0,
        ]);
    }
}
