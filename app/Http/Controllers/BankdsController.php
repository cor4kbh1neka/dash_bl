<?php

namespace App\Http\Controllers;

use App\Models\Groupbank;
use App\Models\Xtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

            if ($validatedData["namegroupxyzt"] != 'nongroup' && $validatedData["namegroupxyzt"] != 'nongroupwd') {
                Groupbank::create([
                    'group' => $validatedData["namegroupxyzt"],
                    'jenis' => $validatedData["grouptype"] == 1 ? 'dp' : 'wd',
                    'min' => 0,
                    'max' => 0
                ]);
            }
            return redirect()->route('listgroup')->with('success', 'Master Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function deletelistgroup($group)
    {
        $responseGetGroup = Http::get('https://back-staging.bosraka.com/banks/group');
        if ($responseGetGroup->failed()) {
            return back()->withInput()->with('error', 'Gagal mengambil data grup');
        }

        $resultGetGroup = $responseGetGroup->json();

        if (!isset($resultGetGroup['data'][$group])) {
            return back()->withInput()->with('error', 'Grup tidak ditemukan');
        }

        $id = $resultGetGroup['data'][$group]["idgroup"];

        $response = Http::delete('https://back-staging.bosraka.com/banks/group/' . $id);
        if ($response->successful()) {
            Groupbank::where('group', $group)->delete();

            return response()->json(['success' => true, 'message' => 'List group berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => $response->json()["message"]]);
        }
    }

    public function deletelistmaster($id)
    {
        $response = Http::delete('https://back-staging.bosraka.com/banks/master/' . $id);
        if ($response->successful()) {
            return redirect()->route('listmaster')->with('success', 'List group berhasil dihapus');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    private function requestApi($endpoint)
    {

        $url = 'https://back-staging.bosraka.com/banks/' . $endpoint;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
            'x-customblhdrs' => '09c90c1d6e1b82015737f88d5f5b827060a57c874babe97f965aaa68072585191ce0eab75404312f4f349ee70029404c2d8f66698b6a4da18990445d1437ff79',
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $responseData = $response->json();
        }

        return $responseData;
    }

    public function setbankmaster($bank)
    {
        $response = Http::get('https://back-staging.bosraka.com/banks/master');
        $data = $response->json()["data"];
        $results = array_filter($data, function ($item) use ($bank) {
            return $item['bnkmstrxyxyx'] === $bank;
        });
        $results = array_values($results);
        $results = $results[0];
        return view('bankds.bankmaster_edit', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
            'data' => $results,
            'listbank' => $data
        ]);
    }

    public function updatesetbank(Request $request, $bank)
    {
        // {
        //     "bnkmstrxyxyx": "cimbniaga2",
        //     "urllogoxxyx": "https://i.ibb.co/n671yNG/Screenshot-44.png",
        //     "statusxyxyy": 2,
        //     "wdstatusxyxyy": 1
        // }
        $dataReq = $request->all();
        unset($dataReq['_token']);
        $dataReq['urllogoxxyx'] = strval(($dataReq["urllogoxxyx"] == null || $dataReq["urllogoxxyx"] == '') ? 0 :  $dataReq["urllogoxxyx"]);
        $dataReq['statusxyxyy'] = intval($dataReq["statusxyxyy"]);
        $dataReq['wdstatusxyxyy'] = intval($dataReq["wdstatusxyxyy"]);

        $response = Http::put('https://back-staging.bosraka.com/banks/master/' . $bank, $dataReq);

        if ($response->successful()) {
            return redirect()->route('listmaster')->with('success', 'List group berhasil dihapus');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function addbankmaster()
    {

        return view('bankds.bankmaster_add', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function setgroupbank($groupbank)
    {

        $response = Http::get('https://back-staging.bosraka.com/banks/group');
        $results = $response->json()["data"];

        if (isset($results[$groupbank])) {
            $data = $results[$groupbank];
        } else {
            $data = [];
        }

        return view('bankds.groupbank_edit', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
            'groupbank' => $groupbank,
            'listgroup' => $results,
            'data' => $data
        ]);
    }

    public function updategroupbank(Request $request, $namagroup)
    {
        $data = $request->all();
        $data['grouptype'] = intval($data['grouptype']);
        $data['min_dp'] = intval($data['min_dp']);
        $data['max_dp'] = intval($data['max_dp']);
        $data['min_wd'] = intval($data['min_wd']);
        $data['max_wd'] = intval($data['max_wd']);

        $response = Http::put('https://back-staging.bosraka.com/banks/group/' . $namagroup, $data);

        if ($response->successful()) {
            Groupbank::where('group', $namagroup)->update([
                'group' => $data['namegroupxyzt']
            ]);
            return redirect()->route('listgroup')->with('success', 'List group berhasil dihapus');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }



    public function addgroupbank()
    {

        return view('bankds.groupbank_add', [
            'title' => 'Set Bank Master',
            'totalnote' => 0,
        ]);
    }

    public function setbank($id, $groupbank)
    {
        $allgroup = [];
        $responseByGroup = Http::get('https://back-staging.bosraka.com/banks/v2/' . $groupbank);
        $resultsGroup = $responseByGroup->json()["data"];

        $filteredGroups = [];
        foreach ($resultsGroup as $groupKey => $groupData) {
            foreach ($groupData as $bank => $bankData) {
                if (isset($bankData['data_bank'])) {
                    foreach ($bankData['data_bank'] as $bankDetail) {
                        if ($bankDetail['idbank'] == $id) {
                            $filteredGroups[$bank] = $bankDetail;
                            break 2;
                        }
                    }
                }
            }
        }

        $responseBank = Http::get('https://back-staging.bosraka.com/banks/master');
        $resultsBank = $responseBank->json()["data"];

        return view('bankds.rekbank_edit', [
            'title' => 'Add & Set Bank',
            'totalnote' => 0,
            'data' => $filteredGroups,
            'dataBank' => $resultsBank,
            'groupbank' => $groupbank
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

        $apiUrl = 'https://back-staging.bosraka.com/banks/v2/add';
        $response = Http::post($apiUrl, $validatedData);

        if ($response->successful()) {
            return redirect('/bankds/listbank/0/0')->with('success', 'Set Bank berhasil ditambahkan');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }

    public function listmaster()
    {
        $response = Http::get('https://back-staging.bosraka.com/banks/master');
        $results = $response->json()["data"];

        return view('bankds.listmaster', [
            'title' => 'List Bank Master',
            'totalnote' => 0,
            'data' => $results
        ]);
    }

    public function listgroup()
    {
        $this->compareData();
        $data = Groupbank::get();
        $datadp = $data->where('jenis', 'dp');
        $datawd = $data->where('jenis', 'wd');

        return view('bankds.listgroup', [
            'title' => 'List Group Bank',
            'totalnote' => 0,
            'data' => $datadp,
            'datawd' => $datawd
        ]);
    }

    public function compareData()
    {
        $response = Http::get('https://back-staging.bosraka.com/banks/group');
        $data = $response->json();
        if ($data['status'] == 'success') {
            $data = $data["data"];

            /* Sesuaikan data lokal dengan API*/
            $group = array_keys($data);
            Groupbank::whereNotIn('group', $group)->delete();
        } else {
            $data = [];
        }

        /* Sesuaikan data API*/
        foreach ($data as $bank => $d) {

            $dataGroup = Groupbank::where('group', $bank)->first();
            if (!$dataGroup && ($bank != 'nongroup' && $bank != 'nongroupwd')) {
                Groupbank::create([
                    'group' => $bank,
                    'jenis' => $d["grouptype"] == 1 ? 'dp' : 'wd',
                    'min' => 0,
                    'max' => 0
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data comparison successful']);
    }



    public function updatelistgroup(Request $request, $jenis)
    {
        try {
            $requestData = $request->all();
            $groupedData = [];
            if ($jenis == 'dp') {
                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'myCheckboxDeposit-') !== false && $value === 'on') {
                        $id = str_replace('myCheckboxDeposit-', '', $key);
                        $groupedData[$id] = [
                            'id' => $id,
                            'min' => $requestData['min_' . $id],
                            'max' => $requestData['max_' . $id],
                        ];
                    }
                }
            } else {
                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'myCheckboxWithdraw-') !== false && $value === 'on') {
                        $id = str_replace('myCheckboxWithdraw-', '', $key);
                        $groupedData[$id] = [
                            'id' => $id,
                            'min' => $requestData['min_' . $id],
                            'max' => $requestData['max_' . $id],
                        ];
                    }
                }
            }

            $groupedData = array_values($groupedData);
            foreach ($groupedData as $d) {
                Groupbank::where('id', $d["id"])->update([
                    'min' => $d["min"],
                    'max' => $d["max"]
                ]);
            }

            return redirect()->route('listgroup')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create data. Error: ' . $e->getMessage());
        }
    }

    public function listbank($group, $groupwd)
    {
        $response = Http::get('https://back-staging.bosraka.com/banks/group');
        $listgroup = $response->json()["data"];
        $listgroupdp = array_filter($listgroup, function ($item) {
            return $item['grouptype'] == 1;
        });
        unset($listgroupdp['nongroup']);
        $listgroupwd = array_filter($listgroup, function ($item) {
            return $item['grouptype'] == 2;
        });
        unset($listgroupwd['nongroupwd']);

        $responseBank = Http::get('https://back-staging.bosraka.com/banks/master');
        $listmasterbank = $responseBank->json()["data"];


        /* DP */
        $listbankdpex = [];
        $listbankdp = [];
        if ($group != 0) {
            $responseBankByGroup = Http::get('https://back-staging.bosraka.com/banks/v2/' . $group);
            if ($responseBankByGroup->json()['status'] !== 'fail') {
                $listbankdp = $responseBankByGroup->json()["data"];
                unset($listbankdp['headers']);
            }

            $responseexcgroupbank = Http::get('https://back-staging.bosraka.com/banks/exc/' . $group);
            if ($responseexcgroupbank->json()['status'] !== 'fail') {
                $listbankdpex = $responseexcgroupbank->json()["data"];
                unset($listbankdpex['headers']);
            }
        }

        $listbankex = [];
        foreach ($listbankdpex as $groupbank => $bankArray) {
            foreach ($bankArray as $bankData => $databank) {
                foreach ($databank['data_bank'] as $bank) {
                    $bankInfo = $bank['idbank'] . ' - ' . $bankData . ' - ' . $bank['namebankxxyy'] . ' - ' . $bank['xynamarekx'] . ' - ' . $bank['norekxyxy'];
                    $listbankex[] = $bankInfo;
                }
            }
        }

        usort($listbankex, function ($a, $b) {
            $bankDataA = explode(' - ', $a)[1];
            $bankDataB = explode(' - ', $b)[1];
            return strcmp($bankDataA, $bankDataB);
        });

        $listbankex = array_unique($listbankex);
        $listbankex = array_values($listbankex);


        /* WD */
        $listbankwdex = [];
        $listbankwd = [];
        if ($groupwd != 0) {
            $responseBankByGroupWd = Http::get('https://back-staging.bosraka.com/banks/v2/' . $groupwd);
            if ($responseBankByGroupWd->json()['status'] !== 'fail') {
                $listbankwd = $responseBankByGroupWd->json()["data"];
                unset($listbankwd['headers']);
            }

            $responseexcgroupbankWd = Http::get('https://back-staging.bosraka.com/banks/exc/' . $groupwd);
            if ($responseexcgroupbankWd->json()['status'] !== 'fail') {
                $listbankwdex = $responseexcgroupbankWd->json()["data"];
                unset($listbankwdex['headers']);
            }
        }

        $listbankexwd = [];
        foreach ($listbankwdex as $groupbank => $bankArray) {
            foreach ($bankArray as $bankData => $databank) {
                foreach ($databank['data_bank'] as $bank) {
                    $bankInfo = $bank['idbank'] . ' - ' . $bankData . ' - ' . $bank['namebankxxyy'] . ' - ' . $bank['xynamarekx'] . ' - ' . $bank['norekxyxy'];
                    $listbankexwd[] = $bankInfo;
                }
            }
        }

        usort($listbankexwd, function ($a, $b) {
            $bankDataA = explode(' - ', $a)[1];
            $bankDataB = explode(' - ', $b)[1];
            return strcmp($bankDataA, $bankDataB);
        });

        $listbankexwd = array_unique($listbankexwd);
        $listbankexwd = array_values($listbankexwd);

        return view('bankds.listbank', [
            'title' => 'List Bank',
            'totalnote' => 0,
            'listgroupdp' => $listgroupdp,
            'listgroupwd' => $listgroupwd,
            'listbankdp' => $listbankdp,
            'listbankwd' => $listbankwd,
            'group' => $group,
            'groupwd' => $groupwd,
            'listmasterbank' => $listmasterbank,
            'listbankdpex' => $listbankdpex,
            'listbankex' => $listbankex,
            'listbankwdex' => $listbankwdex,
            'listbankexwd' => $listbankexwd


        ]);
    }

    public function getGroupBank($bank, $jenis)
    {
        $response = Http::get('https://back-staging.bosraka.com/banks/exc/' . $bank);
        $listgroup = $response->json()["data"];

        // dd($listgroup);

        $responseGroup = Http::get('https://back-staging.bosraka.com/banks/group');
        $listgroupMaster = $responseGroup->json()["data"];

        foreach ($listgroup as $key => $value) {
            if (isset($listgroupMaster[$key])) {
                $listgroup[$key]['grouptype'] = $listgroupMaster[$key]['grouptype'];
            }
        }
        unset($listgroup['headers']);

        $data = array_filter($listgroup, function ($value) use ($jenis) {
            return isset($value['grouptype']) && $value['grouptype'] == $jenis;
        });
        $bcaData = [];

        foreach ($data as $outerKey => $outerValue) {
            if (strpos($outerKey, 'groupbank') === 0) {
                foreach ($outerValue as $innerKey => $innerValue) {
                    if ($innerKey === $bank) {
                        $bcaData[] = [$innerKey => $innerValue];
                    }
                }
            }
        }
        $uniqueData = [];

        foreach ($data as $item) {
            if (isset($item[$bank]['data_bank'][0]['namebankxxyy'])) {
                $namebankxxyy = $item[$bank]['data_bank'][0]['namebankxxyy'];
                $uniqueData[$namebankxxyy] = $item;
            }
        }

        $uniqueData2 = [];
        $uniqueNamebankxxyy = [];
        foreach ($data as $item) {
            if (isset($item[$bank]['data_bank'][0]['namebankxxyy'])) {
                $namebankxxyy = $item[$bank]['data_bank'][0]['namebankxxyy'];
                if (!in_array($namebankxxyy, $uniqueNamebankxxyy)) {
                    $uniqueNamebankxxyy[] = $namebankxxyy;
                    $uniqueData2[] = $item;
                }
            }
        }

        return $uniqueNamebankxxyy;
        // dd($uniqueNamebankxxyy);

        // dd($bcaData);
    }

    public function xdata(Request $request)
    {
        // dd($request);
        $data = Xtrans::query();
        $dataOrigin = $data->get();
        $groupbanks = $dataOrigin->pluck('groupbank')->toArray();

        if ($request->get('checkusername') == 'on') {
            $data->where('username', 'like', '%' . $request->get('username') . '%');
        }

        if ($request->has('checktgldari') && $request->get('checktgldari') == 'on') {
            $gabungDari = date('Y-m-d', strtotime($request->get('gabungdari')));
            $data->where('updated_at', '>=', $gabungDari . " 00:00:00");
        }

        if ($request->has('checktglhingga') && $request->get('checktglhingga') == 'on') {
            $tanggalGabungHingga = date('Y-m-d', strtotime($request->get('gabunghingga')));
            $data->where('updated_at', '<=', $tanggalGabungHingga . " 23:59:59");
        }


        if ($request->get('checkxmincount')) {
            if ($request->get('typexdata') == 'xdeposit') {
                $data->where('sum_dp', '>=', $request->get('xmincount'));
            } else {
                $data->where('sum_wd', '>=', $request->get('xmincount'));
            }
        }

        if ($request->get('checkxmaxcount')) {
            if ($request->get('typexdata') == 'xdeposit') {
                $data->where('sum_dp', '<=', $request->get('xmaxcount'));
            } else {
                $data->where('sum_wd', '<=', $request->get('xmaxcount'));
            }
        }

        if ($request->get('checkbank')) {
            $data->where('bank',  $request->get('bank'));
        }

        if ($request->get('checkgroupbank')) {
            $data->where('groupbank',  $request->get('groupbank'));
        }

        $data = $data->get();
        return view('bankds.xdata', [
            'title' => 'X Data',
            'totalnote' => 0,
            'data' => $data,
            'checkusername' => $request->get('checkusername'),
            'username' => $request->get('username'),
            'typexdata' => $request->get('typexdata'),
            'checktgldari' => $request->get('checktgldari'),
            'gabungdari' => $request->get('gabungdari'),
            'checktglhingga' => $request->get('checktglhingga'),
            'gabunghingga' => $request->get('gabunghingga'),
            'checkxmincount' => $request->get('checkxmincount'),
            'xmincount' => $request->get('xmincount'),
            'checkxmaxcount' => $request->get('checkxmaxcount'),
            'xmaxcount' => $request->get('xmaxcount'),
            'checkbank' => $request->get('checkbank'),
            'bank' => $request->get('bank'),
            'checkgroupbank' => $request->get('checkgroupbank'),
            'groupbank' => $request->get('groupbank'),
            'listgroupbank' => $groupbanks
        ]);
    }

    public function updatelistbank(Request $request, $jenis = "DP")
    {
        try {
            $data = $request->all();

            $filteringDataChecked = [];
            if ($jenis == 'DP') {
                foreach ($data as $key => $value) {
                    if (strpos($key, 'myCheckboxDeposit-') === 0 && $value === 'on') {

                        $groupNumber = substr($key, strlen('myCheckboxDeposit-'));
                        $filteringDataChecked[] = [
                            'banklama' => $data['banklama-' . $groupNumber],
                            'bankbaru' => $data['bankbaru-' . $groupNumber]
                        ];
                    }
                }
            } else {
                foreach ($data as $key => $value) {
                    if (strpos($key, 'myCheckboxWithdraw-') === 0 && $value === 'on') {

                        $groupNumber = substr($key, strlen('myCheckboxWithdraw-'));
                        $filteringDataChecked[] = [
                            'banklama' => $data['banklama-' . $groupNumber],
                            'bankbaru' => $data['bankbaru-' . $groupNumber]
                        ];
                    }
                }
            }

            foreach ($filteringDataChecked as $i => $valueFilter) {
                if ($valueFilter['bankbaru'] != '' || $valueFilter['bankbaru'] != null) {
                    if ($valueFilter['banklama'] != '' || $valueFilter['banklama'] != null) {
                        $deleteData = $this->deleteBankFromGroup($valueFilter['banklama'], $data['groupbank']);
                        if ($deleteData['status'] !== 'success') {
                            return redirect()->back()->with('error', $deleteData['message']);
                        }
                    }

                    $putData = $this->putChangeGroupbank($valueFilter['bankbaru'], $data['groupbank']);
                    if ($putData['status'] !== 'success') {
                        return redirect()->back()->with('error', $putData['message']);
                    }
                } else {
                    return redirect()->back()->with('error', 'Bank tidak boleh kosong');
                }
            }

            return redirect()->back()->with('success', 'Data ' . $data['groupbank'] .  ' berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function putChangeGroupbank($id, $groupbank)
    {
        $apiUrl = 'https://back-staging.bosraka.com/banks/v3/' . $id;
        $data = [
            'namegroupxyzt' => $groupbank
        ];
        $response = Http::put($apiUrl, $data);
        return $response->json();
    }

    private function deleteBankFromGroup($id, $groupbank)
    {
        $url = 'https://back-staging.bosraka.com/banks/arr/' . $id .  '/' . $groupbank;
        $response = Http::delete($url);
        return $response->json();
    }

    // public function xdata()
    // {

    //     return view('bankds.xdata', [
    //         'title' => 'X Data',
    //         'totalnote' => 0,
    //     ]);
    // }

    public function deletelistbank($id, $groupbank)
    {
        $response = Http::delete('https://back-staging.bosraka.com/banks/arr/' . $id . '/' . $groupbank);
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'List bank berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => $response->json()["message"]]);
        }
    }

    public function updatedetailbank(Request $request)
    {
        $dataReq = $request->all();
        $data =
            [
                "masterbnkxyxt" => $dataReq['bankmaster'],
                "namebankxxyy" => $dataReq['bankname'],
                "xynamarekx" => $dataReq['namarek'],
                "norekxyxy" => str_replace('-', '', $dataReq['nomorrek']),
                "yyxxmethod" => $dataReq['methode'],
                "barcodexrxr" => $dataReq['urlbarcode'] == '' ? '0' : $dataReq['urlbarcode']

            ];
        $idbank = $dataReq['idbank'];
        $bankname_old = $dataReq['bankname_old'];
        $response = Http::put('https://back-staging.bosraka.com/banks/v2/' . $idbank . '/' . $bankname_old, $data);

        if ($response->successful()) {
            return redirect('/bankds/listbank/0/0')->with('success', 'Data berhasil diupdate');
        } else {
            return back()->withInput()->with('error', $response->json()["message"]);
        }
    }
}
