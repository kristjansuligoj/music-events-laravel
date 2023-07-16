<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function musicians()
    {
        return $this->belongsToMany(Musician::class, 'musicians_genres', 'genre_id', 'musician_id');
    }

    public function songs()
    {
        return $this->belongsToMany(SongCopy::class, 'songs_genres', 'genre_id', 'song_id');
    }
}
