<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\BettingStatus;

class Bettings extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transfercode', 'username', 'status'];

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

    protected $table = 'bettings';

    public function bettingstatus()
    {
        return $this->hasMany(BettingStatus::class, 'bet_id');
    }
}
