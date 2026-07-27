<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weathers';

    protected $fillable = [
        'country',
        'city',
        'temperature',
        'humidity',
        'wind_speed',
        'precipitation',
        'condition',
        'recorded_at',
    ];

    protected $casts = [
        'temperature' => 'float',
        'humidity' => 'integer',
        'wind_speed' => 'float',
        'precipitation' => 'float',
        'recorded_at' => 'datetime',
    ];
}