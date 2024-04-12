<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;

class DepoWd extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['username', 'amount', 'keterangan', 'jenis', 'bank', 'mbank', 'mnamarek', 'mnorek', 'txnid', 'current_balance', 'status', 'approved_by'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->id = Str::uuid()->toString();
        });
    }

    protected $table = 'depo_wd';
}
