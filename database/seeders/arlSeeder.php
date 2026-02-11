<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $arl = [
            ['id' => 1, 'nombre' => 'ARL Positiva', 'descripcion' => 'Administradora de riesgos laborales con amplia cobertura.'],
            ['id' => 2, 'nombre' => 'Seguros Bolívar S.A', 'descripcion' => 'Empresa aseguradora enfocada en riesgos laborales.'],
            ['id' => 3, 'nombre' => 'Seguros de Vida Aurora S.A', 'descripcion' => 'Compañía especializada en la gestión de riesgos laborales.'],
            ['id' => 4, 'nombre' => 'Liberty Seguros de Vida', 'descripcion' => 'Seguros de vida y riesgos laborales con alta calidad.'],
            ['id' => 5, 'nombre' => 'Mapfre Colombia Vida Seguros S.A.', 'descripcion' => 'Administradora de riesgos laborales con experiencia en el sector.'],
            ['id' => 6, 'nombre' => 'Riesgos Laborales Colmena', 'descripcion' => 'Comprometida con el bienestar y seguridad laboral.'],
            ['id' => 7, 'nombre' => 'Seguros de Vida Alfa S.A', 'descripcion' => 'Entidad aseguradora reconocida en riesgos laborales.'],
            ['id' => 8, 'nombre' => 'Seguros de Vida Colpatria S.A', 'descripcion' => 'Gestión integral de riesgos laborales para empleados.'],
        ];

        DB::table('arl')->insert($arl);
    }
}
