<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Bettings;
use App\Models\BettingTransactions;

class BettingStatus extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['bet_id', 'status'];

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

    protected $table = 'betting_status';

    public function betting()
    {
        return $this->belongsTo(Bettings::class, 'id');
    }

    public function bettingtransactions()
    {
        return $this->hasMany(BettingTransactions::class, 'betstatus_id');
    }
}
