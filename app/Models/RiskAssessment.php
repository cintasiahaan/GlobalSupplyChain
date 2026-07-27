<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiskAssessment extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'risk_assessments';


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'country_id',

        'weather_risk',

        'economic_risk',

        'currency_risk',

        'political_risk',

        'port_risk',

        'risk_score',

        'risk_level',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'country_id' => 'integer',

        'weather_risk' => 'decimal:2',

        'economic_risk' => 'decimal:2',

        'currency_risk' => 'decimal:2',

        'political_risk' => 'decimal:2',

        'port_risk' => 'decimal:2',

        'risk_score' => 'decimal:2',

    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    |
    | Satu Risk Assessment dimiliki oleh satu Country.
    |
    */

    public function country()
    {
        return $this->belongsTo(
            Country::class,
            'country_id'
        );
    }
}