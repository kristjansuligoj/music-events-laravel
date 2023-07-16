<?php

namespace App\Models;

class Song extends Model
{
    public string $title;

    public string $musician;

    public array $genre;

    public int $length;

    public string $releaseDate;

    public array $authors;

    public static function createFromArray(array $data): Song {
        $song = new Song();
        $song->title = $data['title'];
        $song->musician = $data['musician'];
        $song->genre = $data['genre'];
        $song->length = $data['length'];
        $song->releaseDate = $data['releaseDate'];

        // If it is an array, do nothing
        if (is_array($data['authors'])) {
            $song->authors = $data['authors'];
        } else { // Else explode it by the string
            $song->authors = explode(',', $data['authors']);
        }

        return $song;
    }
}
