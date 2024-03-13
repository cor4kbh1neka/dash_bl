<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowedip extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'username', 'password', 'currency', 'min', 'max', 'maxpermatch', 'casinotablelimit', 'companykey', 'serverid'];
    protected $table = 'allowed_ips';
}
