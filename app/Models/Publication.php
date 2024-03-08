<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'publication_date',
        'isPublished',
        'id_user',
        'id_karaoke'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function karaoke()
    {
        return $this->belongsTo(Karaoke::class, 'id_karaoke');
    }
}
