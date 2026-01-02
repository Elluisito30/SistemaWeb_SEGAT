<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trabajador;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Hash;

class pruebaRolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // 1. GERENTE
        $userGerente = User::create([
            'name' => 'Gerente',
            'email' => 'gerente@segat.gob.pe',
            'password' => Hash::make('gerente'),
            'role' => 'gerente',
        ]);

        // 2. TRABAJADOR 1
        $userTrabajador1 = User::create([
            'name' => 'Melanie Tello Fuentes',
            'email' => 'melanie.tello@segat.gob.pe',
            'password' => Hash::make('melanieTello'),
            'role' => 'trabajador',
        ]);

        Trabajador::create([
            'user_id' => $userTrabajador1->id,
            'nombres' => 'Melanie',
            'apellidos' => 'Tello Fuentes',
            'edad' => 32,
            'email' => 'melanie.tello@segat.gob.pe',
            'sexo' => 'Femenino',
            'estado_civil' => 'Casado',
        ]);

        // 3. TRABAJADOR 2
        $userTrabajador2 = User::create([
            'name' => 'Tania Chavez Alva',
            'email' => 'tania.chavez@segat.gob.pe',
            'password' => Hash::make('taniaChavez'),
            'role' => 'trabajador',
        ]);

        Trabajador::create([
            'user_id' => $userTrabajador2->id,
            'nombres' => 'Tania',
            'apellidos' => 'Chavez Alva',
            'edad' => 28,
            'email' => 'tania.chavez@segat.gob.pe',
            'sexo' => 'Femenino',
            'estado_civil' => 'Soltero',
        ]);

        // 4. CIUDADANO/CONTRIBUYENTE 1
        $userCiudadano1 = User::create([
            'name' => 'Germain Cruz Vargas',
            'email' => 'germain.cruz@gmail.com',
            'password' => Hash::make('germainCruz'),
            'role' => 'ciudadano',
        ]);

        Contribuyente::create([
            'user_id' => $userCiudadano1->id,
            'id_tipoDocumento' => 1,
            'numDocumento' => '45678912',
            'genero' => 'M',
            'telefono' => '044521478',
            'celula' => '987654321',
            'email' => 'germain.cruz@gmail.com',
            'tipoContribuyente' => 'N',
            'id_domicilio' => 1,
        ]);

        // 5. CIUDADANO/CONTRIBUYENTE 2
        $userCiudadano2 = User::create([
            'name' => 'Luis Cruz Esquivel',
            'email' => 'luis.cruz@outlook.com',
            'password' => Hash::make('luisCruz'),
            'role' => 'ciudadano',
        ]);

        Contribuyente::create([
            'user_id' => $userCiudadano2->id,
            'id_tipoDocumento' => 1,
            'numDocumento' => '72456189',
            'genero' => 'M',
            'telefono' => '044632589',
            'celula' => '912345678',
            'email' => 'luis.cruz@outlook.com',
            'tipoContribuyente' => 'N',
            'id_domicilio' => 1,
        ]);

        // 6. CIUDADANO/CONTRIBUYENTE 3
        $userCiudadano3 = User::create([
            'name' => 'Renato Quiñones Arriaga',
            'email' => 'renato.quinones@hotmail.com',
            'password' => Hash::make('renatoQuinones'),
            'role' => 'ciudadano',
        ]);

        Contribuyente::create([
            'user_id' => $userCiudadano3->id,
            'id_tipoDocumento' => 1,
            'numDocumento' => '68234517',
            'genero' => 'M',
            'telefono' => '044745896',
            'celula' => '998877665',
            'email' => 'renato.quinones@hotmail.com',
            'tipoContribuyente' => 'N',
            'id_domicilio' => 1,
        ]);
    }
}