<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'genre',
        'release_year',
        'description',
        'rating',
        'is_favorite',
        'user_id', 
        'tmdb_id', 
        'poster',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'release_year' => 'integer',
        'rating' => 'decimal:1',
    ];
}