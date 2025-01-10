<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumnetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $tipos = [
           "Cédula de ciudadanía",
           "Pasaporte",
           "Licencia de conducir",
           "Tarjeta de identificación",
           "Tarjeta de residencia ",
        ];

        foreach ($tipos as $key) {
            DB::table("tipos_documento")->insert([
                "nombre" => $key,
                "created_at"=> now(),
                "updated_at"=> now(),
            ]);
        }
    }
}

