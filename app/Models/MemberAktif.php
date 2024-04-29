<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\TransactionsSaldo;

class MemberAktif extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'username', 'referral'];
    protected $table = 'member_aktif';
}
