<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winlossYear extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = ['username', 'count', 'year', 'deposit', 'withdraw'];
    protected $table = 'winloss_year
    ';
}
