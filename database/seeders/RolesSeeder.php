<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            "nombre"=>"Superadmin",
            "estatus"=>"1"
        ]);
        Roles::create([
            "nombre"=>"Administrador",
            "estatus"=>"1"
        ]);
        Roles::create([
            "nombre"=>"Ciudadano",
            "estatus"=>"1"
        ]);
    }
}
