<?php

use App\Livewire\DashboardPrincipalComponent;
use App\Livewire\GestionPoliticasComponent;
use App\Livewire\ListarVisitantesComponent;
use App\Livewire\RegistroVisitanteComponent;
use App\Livewire\RegistroEmpleadoComponent;
use App\Livewire\ListarEmpleadosComponent;
use App\Livewire\ListarPoliticasComponent;
use App\Livewire\ListarVisitasComponent;
use App\Livewire\PruebasComponent;
use App\Livewire\RegistroPoliticasComponent;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

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


    Route::get('/dashboard', DashboardPrincipalComponent::class)->name('dashboard');
    //mi perfil 
    Route::get('/configuracion/perfil', [UserProfileController::class, 'show'])->name('perfil.ver');
    //visitantes
    Route::get('/verVisitantes', ListarVisitantesComponent::class)->name('visitantes.listar');
    //empleados
    Route::get('/verEmpleados', ListarEmpleadosComponent::class)->name('empleados.listar');
    Route::get('/registroEmpleado', RegistroEmpleadoComponent::class)->name('empleados.create');

    //politicas
    Route::get('/registroPoliticas', RegistroPoliticasComponent::class)->name('politicas.registro');
    Route::get('/configuracion/politicas', ListarPoliticasComponent::class)->name('politicas.listar');


    //visitas
    Route::get('/verVisitas', ListarVisitasComponent::class)->name('visitas.listar');
});
