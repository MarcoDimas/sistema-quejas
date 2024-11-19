<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsuarioSeeder extends Seeder
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
            'id_roles' => 3,
            'id_dependencia' => null,
        ]);
    }
}
