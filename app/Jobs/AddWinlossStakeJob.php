<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WinlossbetDay;
use App\Models\WinlossbetMonth;
use App\Models\WinlossbetYear;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AddWinlossStakeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $transfercode = $this->data['transfercode'];
            $portfolio = $this->data['portfolio'];
            $winloss = $this->data['winloss'];
            $jenis = $this->data['jenis'];
            Log::info('Transfer Code:', ['transfercode' => $transfercode, 'portfolio' => $portfolio]);
            $response = $this->getApi($transfercode, $portfolio);
            Log::info('API Response:', ['response' => $response]);
            if ($response["error"]["id"] === 0) {
                $results = $response["result"][0];
                $username = $results['username'];
                if ($jenis === 'deduct') {
                    $amount = $results['stake'];
                } else {
                    if ($winloss > 0) {
                        $amount = $winloss;
                    } else {
                        $amount = abs($results['winloss']);
                    }
                }


                $winlossbet_day = WinlossbetDay::where('username', $username)
                    ->where('portfolio', $portfolio)
                    ->where('day', date('d'))
                    ->where('month', date('m'))
                    ->where('year', date('Y'))->first();

                if ($winlossbet_day) {
                    if ($jenis == 'deduct') {
                        $winlossbet_day->increment('stake', $amount);
                    } else if ($jenis == 'settle') {
                        $winlossbet_day->increment('winloss', $amount);
                    }
                } else {
                    $winlossbet_day = WinlossbetDay::create([
                        'username' => $username,
                        'portfolio' => $portfolio,
                        'day' => date('d'),
                        'month' => date('m'),
                        'year' => date('Y'),
                        'stake' => $jenis == 'deduct' ? $amount : 0,
                        'winloss' => $jenis == 'settle' ? $amount : 0
                    ]);
                }

                /* Winloss Bet Month */
                $winlossbet_month = WinlossbetMonth::where('username', $username)
                    ->where('portfolio', $portfolio)
                    ->where('month', date('m'))
                    ->where('year', date('Y'))->first();

                if ($winlossbet_month) {
                    if ($jenis == 'deduct') {
                        $winlossbet_month->increment('stake', $amount);
                    } else if ($jenis == 'settle') {
                        $winlossbet_month->increment('winloss', $amount);
                    }
                } else {
                    $winlossbet_month = WinlossbetMonth::create([
                        'username' => $username,
                        'portfolio' => $portfolio,
                        'month' => date('m'),
                        'year' => date('Y'),
                        'stake' => $jenis == 'deduct' ? $amount : 0,
                        'winloss' => $jenis == 'settle' ? $amount : 0
                    ]);
                }

                /* Winloss Bet Year */
                $winlossbet_year = WinlossbetYear::where('username', $username)
                    ->where('portfolio', $portfolio)
                    ->where('year', date('Y'))->first();

                if ($winlossbet_year) {
                    if ($jenis == 'deduct') {
                        $winlossbet_year->increment('stake', $amount);
                    } else if ($jenis == 'settle') {
                        $winlossbet_year->increment('winloss', $amount);
                    }
                } else {
                    WinlossbetYear::create([
                        'username' => $username,
                        'portfolio' => $portfolio,
                        'year' => date('Y'),
                        'stake' => $jenis == 'deduct' ? $amount : 0,
                        'winloss' => $jenis == 'settle' ? $amount : 0
                    ]);
                }

                return;
            }
        } catch (\Exception $e) {
            // Tangani kesalahan di sini, misalnya, log pesan kesalahan
            Log::error('Failed to process AddWinlossStakeJob: ' . $e->getMessage());
            // Jika Anda ingin melakukan retry atau menetapkan status lainnya, Anda dapat melakukannya di sini
        }
    }

    private function getApi($refNos, $portfolio)
    {
        $data = [
            'refNos' => $refNos,
            'portfolio' => $portfolio,
            'companyKey' => env('COMPANY_KEY'),
            'language' => 'en',
            'serverId' => env('SERVERID')
        ];
        $apiUrl = 'https://ex-api-demo-yy.568win.com/web-root/restricted/report/get-bet-list-by-refnos.aspx';

        $response = Http::post($apiUrl, $data);
        return $response->json();
    }
}
