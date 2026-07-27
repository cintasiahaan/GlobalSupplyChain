<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $table = 'ports';

    protected $fillable = [
        'port_name',
        'country',
        'city',
        'latitude',
        'longitude',
        'status',
        'congestion_level',
        'delay_hours',
        'throughput',
        'risk_level',
        'description',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'delay_hours' => 'float',
        'throughput' => 'float',
        'recorded_at' => 'datetime',
    ];
}