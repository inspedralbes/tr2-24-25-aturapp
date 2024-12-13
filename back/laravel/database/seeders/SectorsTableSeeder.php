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
        DB::table('sectors')->insert([
            ['sector'=>'lavabo-alumnat'],
            ['sector'=>'lavabo-dones'],
            ['sector'=>'ala-ausias'],
            ['sector'=>'ala-bosca'],
            ['sector'=>'dept-catala'],
            ['sector'=>'dept-matematiques'],
            ['sector'=>'p3-inf9'],
            ['sector'=>'pasillo-ausias'],
            ['sector'=>'p3-inf7'],
            ['sector'=>'p3-08'],
            ['sector'=>'p3-06'],
            ['sector'=>'p3-04'],
            ['sector'=>'lab-ciencies-naturals'],
            ['sector'=>'dept-ciencies-naturals'],
            ['sector'=>'pasillo-bosca'],
            ['sector'=>'p3-01'],
            ['sector'=>'p3-02'],
            ['sector'=>'p3-03'],
            ['sector'=>'p3-05'],
            ['sector'=>'p3-07'],
            ['sector'=>'lab-ciencies-naturals-2'],
            ['sector'=>'p3-inf11'],
            ['sector'=>'p3-inf10'],
            ['sector'=>'dept-ll-estangeres'],
            ['sector'=>'dept-tecnologia'],
            ['sector'=>'p3-inf3'],
            ['sector'=>'fin-ala-bosca'],
            ['sector'=>'fin-ala-ausias'],
        ]);
    }
}
