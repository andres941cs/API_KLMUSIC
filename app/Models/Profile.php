<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'date_of_birth',
        'id_user',
        // Otras columnas de la tabla profiles
    ];

    # DEVUELVE EL USUARIO DEL PERFIL
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
