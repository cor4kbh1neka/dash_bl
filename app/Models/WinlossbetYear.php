<?php

namespace App\Models;

use App\Models\Companys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinlossbetYear extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'portfolio', 'count', 'year', 'stake', 'winloss'];
    protected $table = 'winlossbet_year';
}
