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
        Estado::updateOrCreate(['estado' => "Pendiente"]);
        Estado::updateOrCreate(['estado' => "En progreso"]);
        Estado::updateOrCreate(['estado' => "Resuelto"]);
    }
}
