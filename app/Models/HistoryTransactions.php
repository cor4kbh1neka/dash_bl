<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HistoryTransactions extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['username', 'invoice', 'refno', 'keterangan', 'debit', 'kredit', 'balance', 'status'];

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

    protected $table = 'history_tansactions';
}
