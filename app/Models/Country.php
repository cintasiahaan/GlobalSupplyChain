<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'capital',
        'region',
        'currency',
        'latitude',
        'longitude',
        'risk_level',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Satu Country memiliki satu Risk Assessment (5 faktor risiko).
     * Relasi ini dipakai di CountryController, DashboardController,
     * RiskAssessmentController, dan beberapa view (Dashboard, countries.*).
     */
    public function riskAssessment(): HasOne
    {
        return $this->hasOne(
            RiskAssessment::class,
            'country_id'
        );
    }

    public function currencyImpacts(): HasMany
    {
        return $this->hasMany(
            CurrencyImpact::class,
            'country_id'
        );
    }
}