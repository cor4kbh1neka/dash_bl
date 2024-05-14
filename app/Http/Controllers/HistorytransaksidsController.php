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
        $username = $request->input('username');

        $checkinvoice = $request->input('checkinvoice');
        $invoice = $request->input('invoice');

        $checkstatus = $request->input('checkstatus');
        $status = $request->input('status');


        $checktransdari = $request->input('checktransdari');
        $transdari = $request->input('transdari');

        $checktranshingga = $request->input('checktranshingga');
        $transhingga = $request->input('transhingga');


        $data = HistoryTransaksi::when($username, function ($query) use ($username) {
            return $query->where('username',  $username);
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
            ->paginate(10);





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
            ->paginate(10);





        $data = HistoryTransaksi::get();
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
            'transhingga' => $transhingga
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


    public function transaksilama()
    {
        return view('historytransaksids.transaksi_lama', [
            'title' => 'History Transaksi Lama',
            'totalnote' => 0,
        ]);
    }
}
