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

class CancelWinlossStakeJob implements ShouldQueue
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
        $username = $this->data['username'];
        $portfolio = $this->data['portfolio'];
        $amount = $this->data['amount'];
        $jenis = $this->data['jenis'];

        $winlossbet_day = WinlossbetDay::where('username', $username)
            ->where('portfolio', $portfolio)
            ->where('day', date('d'))
            ->where('month', date('m'))
            ->where('year', date('Y'))->first();

        if ($winlossbet_day) {
            if ($jenis == 'deduct') {
                $winlossbet_day->decrement('stake', $amount);
            } else if ($jenis == 'settle') {
                $winlossbet_day->decrement('winloss', $amount);
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
                $winlossbet_month->decrement('stake', $amount);
            } else if ($jenis == 'settle') {
                $winlossbet_month->decrement('winloss', $amount);
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
                $winlossbet_year->decrement('stake', $amount);
            } else if ($jenis == 'settle') {
                $winlossbet_year->decrement('winloss', $amount);
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
}
