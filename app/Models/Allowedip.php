<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowedip extends Model
{
    use HasFactory;

    protected $table = 'allowed_ips';
    protected $guarded = [];
}
