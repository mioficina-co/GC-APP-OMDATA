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
        // Lista de departamentos típicos en una empresa
        $departamentos = [
            'Recursos Humanos',
            'Finanzas',
            'Tecnología',
            'Marketing',
            'Ventas',
            'Atención al Cliente',
            'Operaciones',
            'Logística',
            'Legal',
            'Desarrollo de Producto',
            'Investigación y Desarrollo',
            'Compras',
            'Calidad',
            'Soporte Técnico',
            'Administración',
        ];

        foreach ($departamentos as $departamento) {
            DB::table("departamentos")->insert([
                "nombre" => $departamento,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    }
}
