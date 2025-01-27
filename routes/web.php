<?php

use App\Livewire\ListarVisitantesComponent;
use App\Livewire\RegistroVisitanteComponent;
use App\Livewire\RegistroEmpleadoComponent;
use App\Livewire\ListarEmpleadosComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/registroVisitante', RegistroVisitanteComponent::class)->name('visitantes.create');
    Route::get('/verVisitantes', ListarVisitantesComponent::class)->name('visitantes.listar');
    Route::get('/verEmpleados', ListarEmpleadosComponent::class)->name('empleados.listar');
    Route::get('/registroEmpleado', RegistroEmpleadoComponent::class)->name('empleados.create');
});
