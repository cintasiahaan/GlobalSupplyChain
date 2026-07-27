<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'summary',
        'source',
        'category',
        'country',
        'impact_level',
        'url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}