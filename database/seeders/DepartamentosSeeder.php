<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use faker\Factory;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();   

        $cantidad = 5;

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table("departamentos")->insert([
                "nombre"=> $faker->words(1, true),
                "created_at"=> now(),
                "updated_at"=> now(),
            ]);
        }
    }
}
