<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;

class TransactionsSaldoMin extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transaldo_id', 'transactionid', 'transfercode', 'username', 'amount'];

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

    protected $table = 'transaction_saldo_min';
}
