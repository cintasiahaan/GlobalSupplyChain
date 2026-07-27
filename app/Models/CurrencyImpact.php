<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyImpact extends Model
{
    protected $table = 'currency_impacts';

    protected $fillable = [
        'country_id',
        'currency_code',
        'exchange_rate',
        'previous_rate',
        'change_percent',
        'risk_level',
        'impact',
        'recommendation',
        'recorded_at',
    ];

    protected $casts = [
        'exchange_rate' => 'float',
        'previous_rate' => 'float',
        'change_percent' => 'float',
        'recorded_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_id'
        );
    }
}