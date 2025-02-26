<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Andres Gaitan',
            'email' => 'andres.gaitan@omdata.cloud',
            'password' => Hash::make('2025adminA'),
        ]);

        $this->call([
            DepartamentosSeeder::class,
            EmpleadosSeeder::class,
            PaísesSeeder::class,
            RazonvisitaSeeder::class,
            TiposDocumnetoSeeder::class,
            epsSeeder::class,
            arlSeeder::class,
            VisitantesSeeder::class,
            VisitasSeeder::class,
        ]);
    }
}
