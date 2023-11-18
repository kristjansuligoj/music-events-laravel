<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Song extends Model
{
    use HasUuids;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'musician_id',
        'title',
        'length',
        'releaseDate',
    ];

    protected $casts = [
        'releaseDate' => 'date:d-m-Y'
    ];

    public function getReleaseDateAttribute()
    {
        return Carbon::parse($this->attributes['releaseDate'])->format('d-m-Y');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'songs_genres', 'song_id', 'genre_id');
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function musician()
    {
        return $this->belongsTo(Musician::class, 'musician_id', 'id');
    }
}
