<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        # ME PERMITE CREAR UN USUARIO DE PRUEBA AL GENERAR LA BBDD
        \App\Models\User::factory()->create([
            'username' => 'adminName',
            'email' => 'admin@klmusic.com',
            'role' => 'admin',
            'password'=> 123
        ]);
    }
}
