<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieBroadcast extends Model
{
    protected $fillable = [
        'movie_id',
        'channel_nr',
        'broadcasts_at',
    ];

    /**
     * Get the movie that the broadcast belongs to.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
