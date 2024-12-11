<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::updateOrCreate(['name' => "Pendiente"]);
        Estado::updateOrCreate(['name' => "En progreso"]);
        Estado::updateOrCreate(['name' => "Resuelto"]);
    }
}
