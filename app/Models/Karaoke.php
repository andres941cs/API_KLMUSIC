<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karaoke extends Model
{
    use HasFactory;

    protected $fillable = [
        'settings',
        'id_lyric',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class, 'id_song');
    }
}
