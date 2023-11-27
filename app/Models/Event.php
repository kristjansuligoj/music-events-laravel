<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasUuids;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'date',
        'time',
        'description',
        'ticketPrice',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date:d-m-Y'
    ];

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d-m-Y');
    }

    public function musicians()
    {
        return $this->belongsToMany(Musician::class, 'events_musicians', 'event_id', 'musician_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
