<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'rating',
        'age_restriction',
        'description',
        'premieres_at',
    ];

    public function broadcasts()
    {
        return $this->hasMany(MovieBroadcast::class);
    }
}
