<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::updateOrCreate(['rol' => 'Alumne']);
        Rol::updateOrCreate(['rol' => 'Coordinador']);
        Rol::updateOrCreate(['rol' => 'Professor']);
    }
}
