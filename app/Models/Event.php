<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'date',
        'time',
        'description',
        'ticketPrice',
    ];

    public function musicians()
    {
        return $this->belongsToMany(Musician::class, 'events_musicians', 'event_id', 'musician_id');
    }
}
