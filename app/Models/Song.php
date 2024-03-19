<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'genre',
        'id_artist',
        'image'
    ];

    // public function album()
    // {
    //     return $this->belongsTo(Album::class, 'id_album');
    // }

    // public function karaokes()
    // {
    //     return $this->hasOne(Karaoke::class, 'id_song');
    // }

    // public function lyrics()
    // {
    //     return $this->hasOne(Lyric::class, 'id_song');
    // }
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'id_artist');
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function lyrics()
    {
        return $this->hasOne(Lyric::class);
    }
}
