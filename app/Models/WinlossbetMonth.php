<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinlossbetMonth extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'portfolio', 'count', 'month', 'year', 'stake', 'winloss'];
    protected $table = 'winlossbet_month';
}
