<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use GuzzleHttp\Psr7\Request;

class DepositdsController extends Controller
{
    public function index($jenis)
    {
        $dataTransaksi = DepoWd::whereIn('status', [1, 2])->where('jenis', $jenis)->orderBy('updated_at', 'DESC')->get()
            ->map(function ($item) {
                $timestamp = explode(' ', $item->created_at);
                $item['date'] = date('d-m-Y', strtotime($timestamp[0]));
                $item['time'] = $timestamp[1];
                $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                $item['mbank'] = strtoupper($item->mbank);
                $item['mnamarek'] = strtoupper($item->mnamarek);
                $item['mnorek'] = strtoupper($item->mnorek);
                $item['balance'] = number_format($item->balance * 1000, 0, '.', ',');
                $item['status'] = $item['status'] == 1 ? 'accept' : 'cancel';

                return $item;
            });

        $data = DepoWd::join('member', 'depo_wd.username', '=', 'member.username')
            ->select('depo_wd.*', 'member.status as statususer', 'member.keterangan as ketmember')
            ->where('depo_wd.status', 0)
            ->where('depo_wd.jenis', $jenis)
            ->orderBy('depo_wd.created_at', 'ASC')
            ->get()
            ->map(function ($item) {
                $timestamp = explode(' ', $item->created_at);
                $item['date'] = date('d-m-Y', strtotime($timestamp[0]));
                $item['time'] = $timestamp[1];
                $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                $item['mbank'] = strtoupper($item->mbank);
                $item['mnamarek'] = strtoupper($item->mnamarek);
                $item['mnorek'] = strtoupper($item->mnorek);
                $item['balance'] = number_format($item->balance * 1000, 0, '.', ',');

                return $item;
            });

        $groupedData = $data->groupBy('mbank');
        $bankCounts = $groupedData->map(function ($items, $bank) {
            return count($items);
        });

        $bca = $bankCounts->get('BCA') == '' ? 0 : $bankCounts->get('BCA');
        $bca1 = $bankCounts->get('BCA1') == '' ? 0 : $bankCounts->get('BCA1');
        $bni = $bankCounts->get('BNI') == '' ? 0 : $bankCounts->get('BNI');
        $bri = $bankCounts->get('BRI') == '' ? 0 : $bankCounts->get('BRI');
        $mandiri = $bankCounts->get('MANDIRI') == '' ? 0 : $bankCounts->get('MANDIRI');
        $cimb = $bankCounts->get('CIMB') == '' ? 0 : $bankCounts->get('CIMB');
        $danamon = $bankCounts->get('DANAMON') == '' ? 0 : $bankCounts->get('DANAMON');
        $permata = $bankCounts->get('PERMATA') == '' ? 0 : $bankCounts->get('PERMATA');
        $panin = $bankCounts->get('PANIN') == '' ? 0 : $bankCounts->get('PANIN');
        $bsi = $bankCounts->get('BSI') == '' ? 0 : $bankCounts->get('BSI');
        $dana = $bankCounts->get('DANA') == '' ? 0 : $bankCounts->get('DANA');
        $gopay = $bankCounts->get('GOPAY') == '' ? 0 : $bankCounts->get('GOPAY');
        $ovo = $bankCounts->get('OVO') == '' ? 0 : $bankCounts->get('OVO');
        $pulsa = $bankCounts->get('PULSA') == '' ? 0 : $bankCounts->get('PULSA');
        $linkaja = $bankCounts->get('LINKAJA') == '' ? 0 : $bankCounts->get('LINKAJA');
        $totalBankcounts = $bankCounts->sum();

        if ($jenis == 'WD') {
            $path = 'withdrawds.index';
            $title = 'Withdrawal';
        } else {
            $path = 'depositds.index';
            $title = 'Deposit';
        }

        return view($path, [
            'title' => $title,
            'data' => $data,
            'bankCounts' => $bankCounts,
            'totalnote' => 0,
            'bca' => $bca,
            'bca1' => $bca1,
            'bni' => $bni,
            'bri' => $bri,
            'mandiri' => $mandiri,
            'cimb' => $cimb,
            'danamon' => $danamon,
            'permata' => $permata,
            'panin' => $panin,
            'bsi' => $bsi,
            'dana' => $dana,
            'gopay' => $gopay,
            'ovo' => $ovo,
            'pulsa' => $pulsa,
            'linkaja' => $linkaja,
            'totalBankcounts' => $totalBankcounts,
            'dataTransaksi' => $dataTransaksi
        ]);
    }

    public function getDataHistory($username, $jenis)
    {
        if ($jenis == "ALL") {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        } else {
            $dataHistory = DepoWd::where('username', $username)->whereIn('status', [1, 2])->where('jenis', $jenis)->get()
                ->map(function ($item) {
                    $item['amount'] = number_format($item->amount * 1000, 0, '.', ',');
                    return $item;
                });
        }


        return $dataHistory;
    }
}
