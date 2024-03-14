<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Agents;
use App\Models\Transactions;
use App\Models\BettingStatus;
use Illuminate\Support\Facades\Http;

class ApiBolaControllers extends Controller
{
    public function Bonus()
    {
        return '/Bonus';
    }

    public function Cancel()
    {
        return '/Cancel';
    }

    public function Deduct()
    {
        return '/Deduct';
    }

    public function GetBalance()
    {
        return '/GetBalance';
    }

    public function Rollback()
    {
        return '/Rollback';
    }

    public function Settle()
    {
        return '/Settle';
    }

    public function GetBetStatus()
    {
        return '/GetBetStatus';
    }

    public function ReturnStake()
    {
        return '/ReturnStake';
    }
}
