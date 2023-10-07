<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public $timestamps = false;
}
