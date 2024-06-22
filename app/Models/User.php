<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasUuids;
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public $timestamps = false;

    public function attending()
    {
        return $this->belongsToMany(Event::class, 'event_participants', 'user_id', 'event_id');
    }
}
