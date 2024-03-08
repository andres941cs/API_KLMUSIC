<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'release_date',
        'genre',
        'id_artist'
    ];
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'id_artist');
    }
}
