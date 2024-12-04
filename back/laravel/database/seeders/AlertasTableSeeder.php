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
        Alerta::create(['alumno_id' => 1, 'sector_id' => 1]);
        Alerta::create(['alumno_id' => 2, 'sector_id' => 2]);
        Alerta::create(['alumno_id' => 3, 'sector_id' => 3]);
    }
}
