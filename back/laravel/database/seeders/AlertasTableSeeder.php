<?php

namespace Database\Seeders;

use App\Models\Alerta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alerta::updateOrCreate(['alumno_id' => 1, 'sector_id' => 1, 'estado' => 1]);
        Alerta::updateOrCreate(['alumno_id' => 2, 'sector_id' => 2, 'estado' => 2]);
        Alerta::updateOrCreate(['alumno_id' => 3, 'sector_id' => 3, 'estado' => 3]);
    }
}
