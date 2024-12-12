<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolsTableSeeder::class);
        $this->call(CursTableSeeder::class);
        $this->call(TornsTableSeeder::class);
        // $this->call(BlacklistsTableSeeder::class);
        $this->call(PlantaTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(PreguntaTableSeeder::class);

        User::updateOrCreate([
            'nom' => 'nom1',
            'cognoms' => 'cognom1',
            'dni' => '12345678Y',
            'email' => 'email1@example.com',
            'password' => 'password1',
            'rol' => 1,
            'curs' => 2,
            'torn' => 1
        ]);
        User::updateOrCreate([
            'nom' => 'nom2',
            'cognoms' => 'cognom2',
            'dni' => '12345678Z',
            'email' => 'email2@example.com',
            'password' => 'password2',
            'rol' => 1,
            'curs' => 4,
            'torn' => 2
        ]);
        User::updateOrCreate([
            'nom' => 'nom3',
            'cognoms' => 'cognom3',
            'dni' => '12345678X',
            'email' => 'email3@example.com',
            'password' => 'password3',
            'rol' => 2,
            'curs' => 3,
            'torn' => 1
        ]);

        // $this->call(MessagesTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(AlertasTableSeeder::class);
    }
}
