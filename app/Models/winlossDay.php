<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winlossDay extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = ['username', 'count', 'day', 'month', 'year', 'deposit', 'withdraw'];
    protected $table = 'winloss_day';
}
