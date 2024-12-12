<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectores = [
            ['sector'=>'lavabo-alumnat', 'planta_id'=>4],
            ['sector'=>'lavabo-dones', 'planta_id'=>4],
            ['sector'=>'ala-ausias', 'planta_id'=>4],
            ['sector'=>'ala-bosca', 'planta_id'=>4],
            ['sector'=>'dept-catala', 'planta_id'=>4],
            ['sector'=>'dept-matematiques', 'planta_id'=>4],
            ['sector'=>'p3-inf9', 'planta_id'=>4],
            ['sector'=>'pasillo-ausias', 'planta_id'=>4],
            ['sector'=>'p3-inf7', 'planta_id'=>4],
            ['sector'=>'p3-08', 'planta_id'=>4],
            ['sector'=>'p3-06', 'planta_id'=>4],
            ['sector'=>'p3-04', 'planta_id'=>4],
            ['sector'=>'lab-ciencies-naturals', 'planta_id'=>4],
            ['sector'=>'dept-ciencies-naturals', 'planta_id'=>4],
            ['sector'=>'pasillo-bosca', 'planta_id'=>4],
            ['sector'=>'p3-01', 'planta_id'=>4],
            ['sector'=>'p3-02', 'planta_id'=>4],
            ['sector'=>'p3-03', 'planta_id'=>4],
            ['sector'=>'p3-05', 'planta_id'=>4],
            ['sector'=>'p3-07', 'planta_id'=>4],
            ['sector'=>'lab-ciencies-naturals-2', 'planta_id'=>4],
            ['sector'=>'p3-inf11', 'planta_id'=>4],
            ['sector'=>'p3-inf10', 'planta_id'=>4],
            ['sector'=>'dept-ll-estangeres', 'planta_id'=>4],
            ['sector'=>'dept-tecnologia', 'planta_id'=>4],
            ['sector'=>'p3-inf3', 'planta_id'=>4],
            ['sector'=>'fin-ala-bosca', 'planta_id'=>4],
            ['sector'=>'fin-ala-ausias', 'planta_id'=>4],
        ];

        foreach ($sectores as $sector) {
            DB::table('sectors')->updateOrInsert(
                ['sector' => $sector['sector']], // Condición para buscar el registro existente
                ['planta_id' => $sector['planta_id']] // Campos a actualizar o insertar
            );
        }
    }
}
