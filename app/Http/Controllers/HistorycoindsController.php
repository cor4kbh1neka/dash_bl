<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use Illuminate\Http\Request;

class HistorycoindsController extends Controller
{
    public function index(Request $request)
    {


        if ($request->query('search_status') == 'accept') {
            $status = 1;
        } else if ($request->query('search_status') == 'cancel') {
            $status = 2;
        } else {
            $status = '';
        }

        $username = $request->query('search_username');
        $jenis = $request->query('search_jenis');
        $agent = $request->query('search_agent');
        $tgldari = $request->query('tgldari') != '' ? date('Y-m-d 00:00:00', strtotime($request->query('tgldari'))) : date("Y-m-d 00:00:00");
        $tglsampai =  $request->query('tglsampai') != '' ?  date('Y-m-d 23:59:59', strtotime($request->query('tglsampai'))) : date("Y-m-d 23:59:59");

        $datHistory = DepoWd::whereIn('status', [1, 2])
            ->when($jenis, function ($query) use ($jenis) {
                if ($jenis === 'M') {
                    return $query->whereIn('jenis', ['DPM', 'WDM']);
                } else {
                    return $query->where('jenis', $jenis);
                }
            })
            ->when($username, function ($query) use ($username) {
                return $query->where('username', 'LIKE', '%' . $username . '%');
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($agent, function ($query) use ($agent) {
                return $query->where('approved_by', $agent);
            })
            ->when($tgldari && $tglsampai, function ($query) use ($tgldari, $tglsampai) {
                return $query->whereBetween('created_at', [$tgldari, $tglsampai]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->map(function ($item) {
                if ($item['jenis'] == 'DPM') {
                    $item['jenis'] = 'Deposit Manual';
                } else if ($item['jenis'] == 'WDM') {
                    $item['jenis'] = 'Withdraw Manual';
                } else if ($item['jenis'] == 'DP') {
                    $item['jenis'] = 'Deposit';
                } else if ($item['jenis'] == 'WD') {
                    $item['jenis'] = 'Withdraw';
                }

                return $item;
            });


        return view('historycoinds.index', [
            'title' => 'List History',
            'data' => $datHistory,

            'totalnote' => 0,
            'search_jenis' => $jenis,
            'search_username' => $username,
            'search_status' => $status,
            'search_agent' => $agent,
            'tgldari' => $tgldari != '' ? date("Y-m-d", strtotime($tgldari)) : $tgldari,
            'tglsampai' => $tglsampai != '' ? date("Y-m-d", strtotime($tglsampai)) : $tglsampai,
        ]);
    }
}
