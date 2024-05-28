<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BonusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bonus')->insert(
            [
                'portfolio' => 'SportsBook',
                'min_turnover' => 500000,
                'min_lose' => 500000,
                'persentase_rolingan' => 0.02,
                'persentase_cashback' => 0.02,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('bonus')->insert(
            [
                'portfolio' => 'VirtualSports',
                'min_turnover' => 500000,
                'min_lose' => 500000,
                'persentase_rolingan' => 0.02,
                'persentase_cashback' => 0.02,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('bonus')->insert(
            [
                'portfolio' => 'Games',
                'min_turnover' => 500000,
                'min_lose' => 500000,
                'persentase_rolingan' => 0.02,
                'persentase_cashback' => 0.02,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('bonus')->insert(
            [
                'portfolio' => 'SeamlessGame',
                'min_turnover' => 500000,
                'min_lose' => 500000,
                'persentase_rolingan' => 0.02,
                'persentase_cashback' => 0.02,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
