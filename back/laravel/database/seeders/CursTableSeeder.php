<?php

namespace Database\Seeders;

use App\Models\Curs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curs::create(['name' => '1DAW']);
        Curs::create(['name' => '2DAW']);
        Curs::create(['name' => '1DAM']);
        Curs::create(['name' => '2DAM']);
        Curs::create(['name' => '1ASIX']);
        Curs::create(['name' => '2ASIX']);
    }
}
