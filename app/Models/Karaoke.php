<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karaoke extends Model
{
    use HasFactory;

    protected $fillable = [
        'settings', 'publication_date', 'isPublished', 'id_user', 'id_lyric',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function lyric()
    {
        return $this->belongsTo(Lyric::class, 'id_lyric');
    }
}
