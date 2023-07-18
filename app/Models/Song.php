<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'musician',
        'title',
        'length',
        'releaseDate',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'songs_genres', 'song_id', 'genre_id');
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function musicians()
    {
        return $this->hasOne(Musician::class, 'id', 'musician');
    }
}
