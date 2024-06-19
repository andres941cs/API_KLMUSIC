<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;

    protected $fillable = [
        'lyric',
        'language',
        'isInstrumental',
        'preview',
        'id_song',
        'url',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class, 'id_song');
    }

    // public function video()
    // {
    //     return $this->belongsTo(Video::class, 'id_video');
    // }

    public function karaoke()
    {
        return $this->hasOne(Karaoke::class);
    }
}
