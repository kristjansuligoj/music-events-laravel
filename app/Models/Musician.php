<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Musician extends Model
{
    use HasUuids;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'age',
        'image',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'musicians_genres', 'musician_id', 'genre_id');
    }

    public function events()
    {
        return $this->belognsToMany(Event::class, 'events_musicians', 'musician_id', 'event_id');
    }
}
