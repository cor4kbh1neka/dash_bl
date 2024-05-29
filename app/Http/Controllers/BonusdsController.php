<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\BonusPengecualian;
use App\Models\Listbonus;
use App\Models\Listbonusdetail;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\WinlossbetDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BonusdsController extends Controller
{
    public function indexlist()
    {
        $data = [];
        return view('bonusds.indexlist', [
            'title' => 'List Cashback dan Rollingan',
            'data' => $data
        ]);
    }

    public function index(Request $request)
    {
        $dataBonusPengecualian = BonusPengecualian::get();
        $data = MemberAktif::get();

        $bonus = $request->input('bonus');
        $gabungdari = $request->input('gabungdari') != null ? date('Y-m-d', strtotime($request->input('gabungdari'))) : '';
        $gabunghingga =  $request->input('gabunghingga') != null ? date('Y-m-d', strtotime($request->input('gabunghingga'))) : '';
        $pengecualian = $request->input('kecuali');

        if ($bonus == 'cashback') {
            /*bonus cahsback*/
            $dataPortfolio = ['Casino', 'Games', 'SeamlessGame', 'ThirdPartySportsBook'];
        } else {
            /*bonus rolingan*/
            $dataPortfolio = ['SportsBook', 'VirtualSports'];
        }

        if ($bonus != null && $gabungdari !== null && $gabunghingga !== null && $pengecualian !== null) {
            $hunter = Member::where('status', 4)
                ->where('keterangan', $pengecualian)
                ->pluck('username')
                ->values()
                ->toArray();

            $query = WinlossbetDay::whereIn('portfolio', $dataPortfolio)
                ->whereBetween('created_at', [$gabungdari . ' 00:00:00', $gabunghingga . ' 23:59:59'])
                ->select('username', DB::raw('SUM(stake) as totalstake'), DB::raw('SUM(winloss) as totalwinloss'))
                ->groupBy('username');


            if (!empty($hunter)) {
                $query->whereNotIn('username', $hunter);
            }

            $results = $query->get();
            foreach ($results as $key => $result) {
                $mBonus = Bonus::where('jenis_bonus', $bonus)->first();
                $total = $bonus == 'cashback' ? $result->totalwinloss : $result->totalstake;
                if ($bonus == 'cashback') {
                    if ($total <= ($mBonus->min * -1)) {
                        $result->totalbonus = abs($total) * $mBonus->persentase;
                    } else {
                        unset($results[$key]);
                    }
                } else {
                    if ($total >= $mBonus->min) {
                        $result->totalbonus = $total * $mBonus->persentase;
                    } else {
                        unset($results[$key]);
                    }
                }
            }
        } else {
            $results = [];
        }

        if ($results instanceof Collection && !$results->isEmpty()) {
            $isproses = true;
        } else {
            $isproses = false;
        }

        // if ($bonus != null && $gabungdari !== null && $gabunghingga !== null && $pengecualian !== null) {
        //     $userStats = [];

        //     foreach ($data as $index => $d) {
        //         // if ($d->username == 'l21wantos') {
        //         foreach ($dataPortfolio as $portfolio) {
        //             $apiResult = $this->getApi($d->username, $portfolio, $gabungdari, $gabunghingga);

        //             if (isset($apiResult['result']) && is_array($apiResult['result']) && !empty($apiResult['result'])) {
        //                 foreach ($apiResult['result'] as $result) {
        //                     if ($result['status'] == 'lose' || $result['status'] == 'won') {
        //                         if (!isset($userStats[$index])) {
        //                             $userStats[$index] = [
        //                                 'username' => $d->username,
        //                                 'totalStake' => 0,
        //                                 'totalWinLose' => 0
        //                             ];
        //                         }
        //                         $userStats[$index]['totalStake'] += $result['stake'];
        //                         $userStats[$index]['totalWinLose'] += $result['winLost'];
        //                     }
        //                 }
        //             }
        //         }
        //         // }
        //     }
        //     dd($userStats);
        // }



        $this->$data = [];
        return view('bonusds.index', [
            'title' => 'Cashback dan Rollingan',
            'data' => $results,
            'dataBonusPengecualian' => $dataBonusPengecualian,
            'totalnote' => 0,
            'bonus' => $bonus,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'pengecualian' => $pengecualian,
            'isproses' => $isproses
        ]);
    }

    private function getApi($username, $portfolio, $gabungdari, $gabunghingga)
    {
        $data = [
            "username" => $username,
            "portfolio" => $portfolio,
            "startDate" => $gabungdari . "T00:00:00.540Z",
            "endDate" => $gabunghingga . "T23:59:59.540Z",
            "companyKey" => env('COMPANY_KEY'),
            "language" => "en",
            "serverId" => env('SERVERID')
        ];
        $apiUrl = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-modify-date.aspx';
        $response = Http::post($apiUrl, $data);

        return $response->json();
    }

    public function store(Request $request, $bonus, $gabungdari, $gabunghingga, $kecuali)
    {

        $data = $request->request->all();
        $bonuses = array_column($data, 'bonus');
        $totalBonus = array_sum($bonuses);

        $prosessSave = Listbonus::create([
            'no_invoice' => $this->generateInvoiceNumber(),
            'periodedari' => $gabungdari,
            'periodesampai' => $gabunghingga,
            'jenis_bonus' => $bonus,
            'kecuali' => $kecuali,
            'total' => $totalBonus,
            'status' => 'Processed'
        ]);

        if ($prosessSave) {
            foreach ($data as $d) {
                //Listbonusdetail
            }
        }




        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    private function generateInvoiceNumber($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $invoiceNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $invoiceNumber .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $invoiceNumber;
    }
}
