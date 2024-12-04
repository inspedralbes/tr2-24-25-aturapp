<?php

namespace Database\Seeders;

use App\Models\Torn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TornsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Torn::create(['torn' => 'Mati']);
        Torn::create(['torn' => 'Tarda']);
    }
}
