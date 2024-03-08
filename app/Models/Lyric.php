<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    use HasFactory;

    protected $fillable = [
        'lyric',
        'lyric_romaji',
        'url',
        'id_song'
    ];

    public function song()
    {
        return $this->belongsTo(Song::class, 'id_song');
    }
}
