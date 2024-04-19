<?php

namespace App\Http\Controllers;

use App\Models\DepoWd;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\DB;

class Menu2Controller extends Controller
{
    public function index()
    {
        // ACC DEPO WD HARI INI
        $tanggal_awal = date('Y-m-d 00:00:00');
        $tanggal_akhir = date('Y-m-d 23:59:59');
        $count_depo_acc = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->where('status', 1)->count();
        $count_depo_all = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->count();
        $count_wd_acc = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WD', 'WDM'])->where('status', 1)->count();
        $count_Wd_all = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP', 'DPM'])->count();
        $total_depo = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DP'])->where('status', 1)->sum('amount');
        $total_depo_manual = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['DPM'])->where('status', 1)->sum('amount');
        $total_wd = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WD'])->where('status', 1)->sum('amount');
        $total_wd_manual = DepoWd::whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->whereIn('jenis', ['WDM'])->where('status', 1)->sum('amount');

        $lastStatuses = $this->getStatusTransaction();
        dd($lastStatuses);
        $count_bet_settled = $lastStatuses->count();
        $total_bet_settled = $lastStatuses->sum();

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
        return view('menu2.index', [
            'title' => 'Menu 2',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    private function getStatusTransaction()
    {
        $dataTransactions = Transactions::select('id')->get();
        $lastStatuses = TransactionStatus::select('trans_id', DB::raw('MAX(urutan) as max_urutan'))
            ->whereIn('trans_id', $dataTransactions->pluck('id'))
            ->groupBy('trans_id');
        $lastStatuses = TransactionStatus::select('transaction_status.trans_id', 'transaction_status.status')
            ->joinSub($lastStatuses, 'last_status', function ($join) {
                $join->on('transaction_status.trans_id', '=', 'last_status.trans_id')
                    ->on('transaction_status.urutan', '=', 'last_status.max_urutan');
            })
            // ->where('transaction_status.status', 'Settled')
            ->get();

        return $lastStatuses;
    }

    public function create()
    {

        return view('menu2.create', [
            'title' => 'Menu 2',
            'totalnote' => 0,
        ]);
    }
}
