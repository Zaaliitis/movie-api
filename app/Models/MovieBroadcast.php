<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieBroadcast extends Model
{
    protected $fillable = [
        'movie_id',
        'channel_nr',
        'broadcasts_at',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
