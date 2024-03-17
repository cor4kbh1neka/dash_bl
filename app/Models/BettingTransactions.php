<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\BettingStatus;

class BettingTransactions extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['betstatus_id', 'txnid', 'jenis', 'amount'];

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

    protected $table = 'betting_transactions';

    // public function bettingstatus()
    // {
    //     return $this->belongsTo(BettingStatus::class);
    // }
}
