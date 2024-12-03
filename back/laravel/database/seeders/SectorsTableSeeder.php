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
            [
                'sector' => 'Comedor',
                'geometry' => DB::raw("ST_GeomFromText('POLYGON((0 0, 0 10, 10 10, 10 0, 0 0))')")
            ],
            [
                'sector' => 'Bany alumnat',
                'geometry' => DB::raw("ST_GeomFromText('POLYGON((20 20, 20 30, 30 30, 30 20, 20 20))')")
            ],
            [
                'sector' => 'Pati',
                'geometry' => DB::raw("ST_GeomFromText('POLYGON((40 40, 40 100, 100 100, 100 40, 40 40))')")
            ]
        ]);
    }
}
