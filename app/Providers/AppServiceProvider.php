<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Xdpwd;
use App\Models\Outstanding;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
        // dd(Auth::check());
        Event::listen(Authenticated::class, function ($event) {
            View::share('dataCount', $this->getDataCount());
        });

        // View::share('dataCount', [
        //     "countDP" => 2,
        //     "countWD" => 3,
        //     "countOuts" => 4,
        //     "countMemo" => 5,
        // ]);

        // if ($this->app->runningInConsole() || $this->app->environment('testing')) {
        //     return;
        // }

        // $currentRoute = Route::getCurrentRoute();
        // $currentUrl = $currentRoute ? $currentRoute->uri() : '';

        // if (!Str::startsWith($currentUrl, 'api/')) {
        //     View::share('dataCount', $this->getDataCount());
        // }
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
