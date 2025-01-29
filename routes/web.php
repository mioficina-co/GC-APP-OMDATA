<?php

use App\Livewire\ListarVisitantesComponent;
use App\Livewire\RegistroVisitanteComponent;
use App\Livewire\RegistroEmpleadoComponent;
use App\Livewire\ListarEmpleadosComponent;
use App\Livewire\PruebasComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('visitantes.create');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/registroVisitante', RegistroVisitanteComponent::class)->name('visitantes.create');

Route::get('/pruebas', PruebasComponent::class)->name('pruebas');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/verVisitantes', ListarVisitantesComponent::class)->name('visitantes.listar');
    Route::get('/verEmpleados', ListarEmpleadosComponent::class)->name('empleados.listar');
    Route::get('/registroEmpleado', RegistroEmpleadoComponent::class)->name('empleados.create');
});
