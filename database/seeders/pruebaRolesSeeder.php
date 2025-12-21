<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class pruebaRolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Gerente Municipal',
            'email' => 'gerente@segat.com',
            'password' => Hash::make('gerente123'),
            'role' => 'gerente',
        ]);
        

        User::create([
            'name' => 'Trabajador',
            'email' => 'trabajador@segat.gob.pe',
            'password' => Hash::make('trabajador'),
            'role' => 'trabajador',
        ]);

        User::create([
            'name' => 'Ciudadano',
            'email' => 'ciudadano@segat.gob.pe',
            'password' => Hash::make('ciudadano'),
            'role' => 'ciudadano',
        ]);
    }
}