<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RazonvisitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $razones = [
            'Reunión de negocios',
            'Visita de cliente',
            'Entrevista de trabajo',
            'Capacitación',
            'Entrega de documentos',
            'Revisión de equipos',
            'Asesoría técnica',
            'Inspección de seguridad',
            'Visita familiar',
            'Reunión de seguimiento',
            'Otro',
        ];

        foreach ($razones as $razonesItems) {
            DB::table('razonvisitas')->insert([
                "nombre"=> $razonesItems,
                "created_at"=> now(),
                "updated_at"=> now(),
            ]);            
        }

    }
}
