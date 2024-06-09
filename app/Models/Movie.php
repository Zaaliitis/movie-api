<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'rating',
        'age_restriction',
        'description',
        'premieres_at',
    ];

    /**
     * Get the broadcasts for the movie.
     */
    public function broadcasts(): HasMany
    {
        return $this->hasMany(MovieBroadcast::class);
    }
}
