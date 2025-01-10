<?php

namespace Database\Seeders;

use App\Models\empleados;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       $faker =  Factory::create();
        $cantidad = 10;
       for ($i = 0; $i < 10; $i++) {
        DB::table("empleados")->insert([
            "nombre"=> $faker->firstName,
            "apellido"=> $faker->lastName,
            "departamento_id"=> $faker->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),    
        ]);
       }
    }
}
