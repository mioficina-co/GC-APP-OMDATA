<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class epsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $eps = [
            ['id' => 1, 'nombre' => 'Aliansalud EPS', 'descripcion' => 'Entidad Promotora de Salud orientada al bienestar de los afiliados.'],
            ['id' => 2, 'nombre' => 'Comfenalco Valle EPS', 'descripcion' => 'EPS comprometida con el cuidado de la salud en el Valle del Cauca.'],
            ['id' => 3, 'nombre' => 'Compensar EPS', 'descripcion' => 'Entidad enfocada en la calidad de los servicios de salud.'],
            ['id' => 4, 'nombre' => 'EPS Sanitas', 'descripcion' => 'EPS líder en la atención integral de salud en Colombia.'],
            ['id' => 5, 'nombre' => 'Famisanar EPS', 'descripcion' => 'Promueve la salud y el bienestar de sus afiliados.'],
            ['id' => 6, 'nombre' => 'Nueva EPS', 'descripcion' => 'EPS con cobertura nacional y enfoque en la calidad de atención.'],
            ['id' => 7, 'nombre' => 'Comfenalco Antioquia EPS', 'descripcion' => 'Entidad que ofrece servicios de salud en Antioquia.'],
            ['id' => 8, 'nombre' => 'S.O.S. S.A. Servicio Occidental de Salud', 'descripcion' => 'Entidad con atención enfocada en la región del occidente.'],
            ['id' => 9, 'nombre' => 'Salud Total EPS', 'descripcion' => 'EPS destacada por su enfoque en el servicio al cliente.'],
        ];

        DB::table('eps')->insert($eps);
    }
}
