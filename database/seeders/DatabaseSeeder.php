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
            'name' => 'Administrador',
            'email' => 'admingcapp@gcapp.com',
            'password' => Hash::make('GCAdmin'),
        ]);

        $this->call([
            DepartamentosSeeder::class,
            EmpleadosSeeder::class,
            PaisesSeeder::class,
            RazonVisitaSeeder::class,
            TiposDocumnetoSeeder::class,
            EpsSeeder::class,
            ArlSeeder::class,
            VisitantesSeeder::class,
            VisitasSeeder::class,
        ]);
    }
}
