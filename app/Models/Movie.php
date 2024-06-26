<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'rating',
        'age_restriction',
        'description',
        'premieres_at',
    ];

    /**
     * Get the broadcasts for the movie.
     *
     * @return HasMany<MovieBroadcast>
     */
    public function broadcasts(): HasMany
    {
        return $this->hasMany(MovieBroadcast::class);
    }
}
