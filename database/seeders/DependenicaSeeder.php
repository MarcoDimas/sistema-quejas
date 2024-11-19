<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dependencia;
class DependenicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Dependencia();
        $role->id = 1;
        $role->nombre = 'EDUCACION';
        $role->descripcion = 'Insitución Educadora';
        $role->estatus = '1';
        $role->save();
    }
}
