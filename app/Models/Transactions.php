<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\TransactionStatus;

class Transactions extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transactionid', 'transfercode', 'username', 'type', 'status'];

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

    protected $table = 'transactions';

    public function transactionstatus()
    {
        return $this->hasMany(TransactionStatus::class, 'trans_id');
    }
}
