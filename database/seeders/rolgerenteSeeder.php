<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class rolgerenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Gerente',
            'email' => 'gerente@segat.gob.pe',
            'password' => Hash::make('gerente'),
            'role' => 'gerente',
            'email_verified_at' => now(),
        ]);
    }
}