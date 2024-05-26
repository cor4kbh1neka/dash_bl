<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use App\Models\DepoWd;
use App\Models\HistoryTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HistorytransaksidsController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->getQueryString();
        $username = $request->input('username');

        $checkinvoice = $request->input('checkinvoice');
        $invoice = $request->input('invoice');

        $checkstatus = $request->input('checkstatus');
        $status = $request->input('status');


        $checktransdari = $request->input('checktransdari');
        $transdari = $request->input('transdari') == null ? date('Y-m-01') . 'T00:00' : $request->input('transdari');

        $checktranshingga = $request->input('checktranshingga');
        $transhingga = $request->input('transhingga') == null ? date('Y-m-t') . 'T23:59' : $request->input('transhingga');


        if ($username != '') {
            $data = HistoryTransaksi::where('username', $username)
                ->when($checkinvoice == 'on' && $invoice != '', function ($query) use ($invoice) {
                    return $query->where('refno', $invoice);
                })
                ->when($checkstatus == 'on' && $status != '', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->when(($checktransdari == 'on' && $transdari != '') || ($checktranshingga == 'on' && $transhingga != ''), function ($query) use ($transdari, $transhingga) {
                    $tgldari = date('Y-m-d H:i:s', strtotime($transdari));
                    $tglsampai = date('Y-m-d H:i:s', strtotime($transhingga));
                    $tglsampai = substr_replace($tglsampai, '59', -2);

                    $query->whereBetween('created_at', [$tgldari, $tglsampai]);
                })
                ->orderBy('created_at', 'desc')
                ->orderBy('urutan', 'desc')
                ->paginate(10);
        } else {
            $data = [];
        }

        return view('historytransaksids.index', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'totalnote' => 0,
            'total' => 0,
            'username' => $username,
            'checkinvoice' => $checkinvoice,
            'invoice' => $invoice,
            'checkstatus' => $checkstatus,
            'status' => $status,
            'checktransdari' => $checktransdari,
            'transdari' => $transdari,
            'checktranshingga' => $checktranshingga,
            'transhingga' => $transhingga,
            'query' => $query
        ]);
    }

    private function getApiBetList()
    {
        $data = [
            "username" => "abangpoorgas",
            "portfolio" => "SportsBook",
            "startDate" => "2024-04-01T00:00:00.540Z",
            "endDate" => "2024-05-30T23:59:59.540Z",
            "companyKey" => "C441C721B2214E658A6D2A72C41D2063",
            "language" => "en",
            "serverId" => "YY-TEST"
        ];
        $response = Http::post('https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-modify-date.aspx', $data);

        return $response->json();
    }


    public function transaksilama(Request $request)
    {
        $query = $request->getQueryString();
        $username = $request->input('username');

        $checkinvoice = $request->input('checkinvoice');
        $invoice = $request->input('invoice');

        $checkstatus = $request->input('checkstatus');
        $status = $request->input('status');


        $checktransdari = $request->input('checktransdari');
        $transdari = $request->input('transdari') == null ? date('Y-m-01') . 'T00:00' : $request->input('transdari');


        $checktranshingga = $request->input('checktranshingga');
        $transhingga = $request->input('transhingga') == null ? date('Y-m-t') . 'T23:59' : $request->input('transhingga');

        if ($username != '') {
            $data = HistoryTransaksi::where('username', $username)
                ->when($checkinvoice == 'on' && $invoice != '', function ($query) use ($invoice) {
                    return $query->where('refno', $invoice);
                })
                ->when($checkstatus == 'on' && $status != '', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->when(($checktransdari == 'on' && $transdari != '') || ($checktranshingga == 'on' && $transhingga != ''), function ($query) use ($transdari, $transhingga) {
                    $tgldari = date('Y-m-d H:i:s', strtotime($transdari));
                    $tglsampai = date('Y-m-d H:i:s', strtotime($transhingga));
                    $tglsampai = substr_replace($tglsampai, '59', -2);

                    $query->whereBetween('created_at', [$tgldari, $tglsampai]);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = [];
        }

        return view('historytransaksids.transaksi_lama', [
            'title' => 'History Transaksi Baru',
            'data' => $data,
            'totalnote' => 0,
            'total' => 0,
            'username' => $username,
            'checkinvoice' => $checkinvoice,
            'invoice' => $invoice,
            'checkstatus' => $checkstatus,
            'status' => $status,
            'checktransdari' => $checktransdari,
            'transdari' => $transdari,
            'checktranshingga' => $checktranshingga,
            'transhingga' => $transhingga,
            'query' => $query
        ]);
    }
}
