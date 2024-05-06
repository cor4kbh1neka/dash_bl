<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Xdpwd;
use App\Models\Outstanding;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View::share('dataCount', $this->getDataCount());
        View::share('dataCount', [
            "countDP" => 2,
            "countWD" => 3,
            "countOuts" => 4,
            "countMemo" => 5,
        ]);
    }

    private function getDataCount()
    {
        $countDataDP = Xdpwd::where('jenis', 'DP')->where('status', 0)->count();
        $countDataWD = Xdpwd::where('jenis', 'WD')->where('status', 0)->count();

        $dataOuts = Outstanding::get();
        $dataOuts = $dataOuts->groupBy('username')->map(function ($group) {
            $totalAmount = $group->sum('amount');
            $count = $group->count();
            return [
                'username' => $group->first()['username'],
                'totalAmount' => $totalAmount,
                'count' => $count,
            ];
        })->count();

        $responseMemo = Http::get('https://back-staging.bosraka.com/memo');
        $resultMemo = $responseMemo->json();
        if ($resultMemo['status'] == 'success') {
            $countMemo = count($resultMemo['data']);
        } else {
            $countMemo = 0;
        }


        return [
            'countDP' => $countDataDP,
            'countWD' => $countDataWD,
            'countOuts' => $dataOuts,
            'countMemo' => $countMemo
        ];
    }
}
