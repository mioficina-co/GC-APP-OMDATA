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
        // Nombres y apellidos comunes en Colombia
        $nombres = ['Carlos', 'Juan', 'Ana', 'María', 'Pedro', 'Laura', 'Luis', 'Felipe', 'Sofía', 'Jorge'];
        $apellidos = ['Gómez', 'Martínez', 'Rodríguez', 'López', 'Pérez', 'Hernández', 'García', 'Díaz', 'Torres', 'Ramírez'];

        // Departamentos (asumido que existen en la base de datos con IDs)
        $departamentos = [1, 2, 3, 4, 5];  // Estos números corresponden a los IDs de los departamentos en tu tabla de departamentos.

        // Crear empleados
        for ($i = 0; $i < 10; $i++) {
            DB::table("empleados")->insert([
                "nombre" => $nombres[array_rand($nombres)], // Elegir aleatoriamente un nombre
                "apellido" => $apellidos[array_rand($apellidos)], // Elegir aleatoriamente un apellido
                "departamento_id" => $departamentos[array_rand($departamentos)], // Asignar aleatoriamente un departamento
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
