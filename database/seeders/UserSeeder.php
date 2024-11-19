<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SUPER ADMINISTRADOR',
            'email' => 'superAdmi@gmail.com',
            'password' => Hash::make('super22'),
            'estatus' => '1', 
            'id_roles' => 1,
            'id_dependencia' => 1,
        ]);

        User::create([
            'name' => 'ADMININSTRADOR',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin22'),
            'estatus' => '1',
            'id_roles' => 2,
            'id_dependencia' => 1, 
        ]);

        User::create([
            'name' => 'Ciudadano',
            'email' => 'ciudadano@gmail.com',
            'password' => Hash::make('ciudadano22'),
            'estatus' => '1', 
            'id_roles' => 3,
            'id_dependencia' => null,
        ]);

    }
}
