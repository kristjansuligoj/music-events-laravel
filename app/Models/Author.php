<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
