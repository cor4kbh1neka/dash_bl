<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\winlossDay;
use App\Models\winlossMonth;
use App\Models\winlossYear;

class CancelWinlossStakeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $username;
    protected $portfolio;
    protected $amount;
    protected $jenis;
    /**
     * Create a new job instance.
     */
    public function __construct($username, $portfolio, $amount, $jenis)
    {
        $this->username = $username;
        $this->portfolio = $portfolio;
        $this->amount = $amount;
        $this->jenis = $jenis;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /* Winloss Bet Day */
        $winloss_day = winlossDay::where('username', $this->username)
            ->where('portfolio', $this->portfolio)
            ->where('day', date('d'))
            ->where('month', date('m'))
            ->where('year', date('Y'))->first();

        if ($winloss_day) {
            if ($this->jenis == 'deduct') {
                $winloss_day->decrement('stake', $this->amount);
            } else if ($this->jenis == 'settle') {
                $winloss_day->decrement('winloss', $this->amount);
            }
        } else {
            $winloss_day = winlossDay::create([
                'username' => $this->username,
                'portfolio' => $this->portfolio,
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
                'stake' => $this->jenis == 'deduct' ? $this->amount : 0,
                'winloss' => $this->jenis == 'settle' ? $this->amount : 0
            ]);
        }

        /* Winloss Bet Month */
        $winloss_month = winlossMonth::where('username', $this->username)
            ->where('portfolio', $this->portfolio)
            ->where('month', date('m'))
            ->where('year', date('Y'))->first();

        if ($winloss_month) {
            if ($this->jenis == 'deduct') {
                $winloss_month->decrement('stake', $this->amount);
            } else if ($this->jenis == 'settle') {
                $winloss_month->decrement('winloss', $this->amount);
            }
        } else {
            $winloss_month = winlossMonth::create([
                'username' => $this->username,
                'portfolio' => $this->portfolio,
                'month' => date('m'),
                'year' => date('Y'),
                'stake' => $this->jenis == 'deduct' ? $this->amount : 0,
                'winloss' => $this->jenis == 'settle' ? $this->amount : 0
            ]);
        }

        /* Winloss Bet Year */
        $winloss_year = winlossYear::where('username', $this->username)
            ->where('portfolio', $this->portfolio)
            ->where('year', date('Y'))->first();

        if ($winloss_year) {
            if ($this->jenis == 'deduct') {
                $winloss_year->decrement('stake', $this->amount);
            } else if ($this->jenis == 'settle') {
                $winloss_year->decrement('winloss', $this->amount);
            }
        } else {
            winlossYear::create([
                'username' => $this->username,
                'portfolio' => $this->portfolio,
                'year' => date('Y'),
                'stake' => $this->jenis == 'deduct' ? $this->amount : 0,
                'winloss' => $this->jenis == 'settle' ? $this->amount : 0
            ]);
        }
    }
}
