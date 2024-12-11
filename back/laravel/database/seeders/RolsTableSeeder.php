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
        Rol::create(['rol' => 'Alumne']);
        Rol::create(['rol' => 'Coordinador']);
        Rol::create(['rol' => 'Professor']);
    }
}