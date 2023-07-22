<?php

namespace App\Enums;

enum GenresEnum:string {
    case Rock = 'Rock';
    case Metal = 'Metal';
    case Rap = 'Rap';
    case Country = 'Country';
    case HipHop = 'Hip hop';
    case Jazz = 'Jazz';
    case Electronic = 'Electronic';

    public static function getAllGenres(): array {
        return [
            self::Rock->name,
            self::Metal->name,
            self::Rap->name,
            self::Country->name,
            self::HipHop->name,
            self::Jazz->name,
            self::Electronic->name,
        ];
    }
}
