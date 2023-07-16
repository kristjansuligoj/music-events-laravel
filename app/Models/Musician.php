<?php

namespace App\Models;

class Musician extends Model
{
    public string $name;

    public array $genre;

    public static function createFromArray(array $data): Musician {
        $musician = new Musician();
        $musician->name = $data['name'];
        $musician->genre = $data['genre'];

        return $musician;
    }
}
