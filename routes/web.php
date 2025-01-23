<?php

use App\Livewire\ListarVisitantes;
use App\Livewire\RegistroVisitanteComponent;
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
    Route::get('/verVisitantes', ListarVisitantes::class)->name('visitantes.listar');
});
