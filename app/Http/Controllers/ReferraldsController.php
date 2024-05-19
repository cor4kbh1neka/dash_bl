<?php

namespace App\Http\Controllers;

use App\Models\Referral1;
use App\Models\Referral2;
use App\Models\Referral3;
use App\Models\Referral4;
use App\Models\Referral5;
use App\Models\ReferralAktif1;
use App\Models\ReferralAktif2;
use App\Models\ReferralAktif3;
use App\Models\ReferralAktif4;
use App\Models\ReferralAktif5;
use App\Models\ReferralDepo1;
use App\Models\ReferralDepo2;
use App\Models\ReferralDepo3;
use App\Models\ReferralDepo4;
use App\Models\ReferralDepo5;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReferraldsController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->getQueryString();
        $upline = $request->input('upline');
        $portfolio = $request->input('portfolio');
        $gabungdari = $request->input('gabungdari', date('Y-m-d'));
        $gabunghingga = $request->input('gabunghingga', date('Y-m-d'));

        $tables = ['ae', 'fj', 'pt', 'ko', 'uz'];

        $queryParts = [];

        foreach ($tables as $table) {
            $tableQuery = DB::table("referral_$table")
                ->join("ref_depo_$table", function ($join) use ($table) {
                    $join->on("referral_$table.upline", '=', "ref_depo_$table.upline")
                        ->on("referral_$table.downline", '=', "ref_depo_$table.downline");
                })
                ->join("ref_aktif_$table", function ($join) use ($table) {
                    $join->on("referral_$table.upline", '=', "ref_aktif_$table.upline")
                        ->on("referral_$table.downline", '=', "ref_aktif_$table.downline");
                })
                ->select(
                    DB::raw("'$table' as source"),
                    "referral_$table.upline",
                    DB::raw('count(referral_' . $table . '.id) as total_referral'),
                    DB::raw('count(ref_depo_' . $table . '.id) as total_deposit'),
                    DB::raw('count(referral_' . $table . '.id) - count(ref_depo_' . $table . '.id) as total_nondeposit'),
                    DB::raw('count(ref_aktif_' . $table . '.id) as total_aktif'),
                    DB::raw('count(referral_' . $table . '.id) - count(ref_aktif_' . $table . '.id) as total_nonaktif'),
                    DB::raw('sum(ref_aktif_' . $table . '.amount) as total_amount')
                )
                ->groupBy("referral_$table.upline");

            if ($upline) {
                $tableQuery->where("referral_$table.upline", '=', $upline);
            }

            if ($portfolio) {
                $tableQuery->where("ref_aktif_$table.portfolio", '=', $portfolio);
            }

            if ($gabungdari && $gabunghingga) {
                $tableQuery->whereBetween("ref_depo_$table.created_at", [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"])
                    ->whereBetween("ref_aktif_$table.created_at", [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"]);
            }

            $queryParts[] = $tableQuery;
        }

        $finalQuery = array_shift($queryParts);
        foreach ($queryParts as $part) {
            $finalQuery->unionAll($part);
        }

        $results = $finalQuery->get();

        return view('referralds.index', [
            'title' => 'Referral',
            'data' => $results,
            'totalnote' => 0,
            'upline' => $upline,
            'portfolio' => $portfolio,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'query' => $query
        ]);
    }

    public function downlinedetail(Request $request, $upline, $jenis)
    {
        $portfolio = $request->input('portfolio');
        $gabungdari = $request->input('gabungdari', date('Y-m-d'));
        $gabunghingga = $request->input('gabunghingga', date('Y-m-d'));

        if ($jenis == 'totaldownline') {
            $data = $this->getTotalDownline($upline, $portfolio, $gabungdari, $gabunghingga);
        } else if ($jenis == 'deposit') {
            $data = $this->getDeposit($upline, $portfolio, $gabungdari, $gabunghingga);
        } else if ($jenis == 'belumdeposit') {
            $data = $this->getBelumDeposit($upline, $portfolio, $gabungdari, $gabunghingga);
        } else if ($jenis == 'aktif') {
            $data = $this->getAktif($upline, $portfolio, $gabungdari, $gabunghingga);
        } else if ($jenis == 'tidakaktif') {
            $data = $this->getTidakAktif($upline, $portfolio, $gabungdari, $gabunghingga);
        } else if ($jenis == 'bonusreferral') {
            $data = $this->getTotalDownline($upline, $portfolio, $gabungdari, $gabunghingga);
        }

        return view('referralds.detail_downline', [
            'title' => 'Downline Detail',
            'totalnote' => 0,
            'data' => $data
        ]);
    }

    private function getTidakAktif($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $dataReferral = ReferralAktif1::where('upline', $upline)->pluck('downline')->toArray();
            $data = Referral1::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $dataReferral = ReferralAktif2::where('upline', $upline)->pluck('downline')->toArray();
            $data = Referral2::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $dataReferral = ReferralAktif3::where('upline', $upline)->pluck('downline')->toArray();
            $data = Referral3::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $dataReferral = ReferralAktif4::where('upline', $upline)->pluck('downline')->toArray();
            $data = Referral4::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $dataReferral = ReferralAktif5::where('upline', $upline)->pluck('downline')->toArray();
            $data = Referral5::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        }
        return $data;
    }

    private function getAktif($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = Referral1::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif1::where('upline', $upline)->where('downline', $row->downline)->first()->amount;
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = Referral2::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif2::where('upline', $upline)->where('downline', $row->downline)->first()->amount;
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = Referral3::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif3::where('upline', $upline)->where('downline', $row->downline)->first()->amount;
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = Referral4::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif4::where('upline', $upline)->where('downline', $row->downline)->first()->amount;
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = Referral5::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif5::where('upline', $upline)->where('downline', $row->downline)->first()->amount;
            }
        }
        return $data;
    }

    private function getBelumDeposit($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $dataReferral = ReferralDepo1::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();
            $data = Referral1::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $dataReferral = ReferralDepo2::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();
            $data = Referral2::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $dataReferral = ReferralDepo3::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();
            $data = Referral3::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $dataReferral = ReferralDepo4::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();
            $data = Referral4::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $dataReferral = ReferralDepo5::where('upline', $upline)
                ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                ->pluck('downline')->toArray();
            $data = Referral5::where('upline', $upline)
                ->whereNotIn('downline', $dataReferral)
                ->get();
            if (!$data->isEmpty()) {
                foreach ($data as $row) {
                    $row->total_amount = 0;
                }
            }
        }
        return $data;
    }

    private function getDeposit($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = Referral1::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralDepo1::where('upline', $upline)->where('downline', $row->downline)
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = Referral2::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralDepo2::where('upline', $upline)->where('downline', $row->downline)
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = Referral3::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralDepo3::where('upline', $upline)->where('downline', $row->downline)
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = Referral4::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralDepo4::where('upline', $upline)->where('downline', $row->downline)
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = Referral5::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralDepo5::where('upline', $upline)->where('downline', $row->downline)
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        }
        return $data;
    }

    private function getTotalDownline($upline, $portfolio, $gabungdari, $gabunghingga)
    {
        if (preg_match('/^[a-e]/i', $upline)) {
            $data = Referral1::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif1::where('upline', $upline)->where('downline', $row->downline)
                    ->when($portfolio != '', function ($query) use ($portfolio) {
                        return $query->where('portfolio', $portfolio);
                    })
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[f-j]/i', $upline)) {
            $data = Referral2::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif2::where('upline', $upline)->where('downline', $row->downline)
                    ->when($portfolio != '', function ($query) use ($portfolio) {
                        return $query->where('portfolio', $portfolio);
                    })
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[k-o]/i', $upline)) {
            $data = Referral3::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif3::where('upline', $upline)->where('downline', $row->downline)
                    ->when($portfolio != '', function ($query) use ($portfolio) {
                        return $query->where('portfolio', $portfolio);
                    })
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[p-t]/i', $upline)) {
            $data = Referral4::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif4::where('upline', $upline)->where('downline', $row->downline)
                    ->when($portfolio != '', function ($query) use ($portfolio) {
                        return $query->where('portfolio', $portfolio);
                    })
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        } elseif (preg_match('/^[u-z]/i', $upline)) {
            $data = Referral5::where('upline', $upline)->get();
            foreach ($data as $row) {
                $row->total_amount = ReferralAktif5::where('upline', $upline)->where('downline', $row->downline)
                    ->when($portfolio != '', function ($query) use ($portfolio) {
                        return $query->where('portfolio', $portfolio);
                    })
                    ->whereBetween('created_at', [$gabungdari, $gabunghingga])
                    ->first()->amount;
            }
        }
        return $data;
    }

    public function bonusreferral()
    {

        return view('referralds.referral_downline', [
            'title' => 'Bonus Referral',
            'totalnote' => 0,
        ]);
    }
}
