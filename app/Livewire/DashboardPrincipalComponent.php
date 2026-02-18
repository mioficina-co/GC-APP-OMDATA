<?php

namespace App\Livewire;

use App\Models\Visitantes;
use Livewire\Component;

class DashboardPrincipalComponent extends Component
{

    public $visitantes;
    public $registrosMensuales;
    public $concurrenciaUsuarios;

    public function mount()
    {

        $this->visitantes = Visitantes::all()->count();
        $this->registrosMensuales = Visitantes::whereMonth('created_at', now()->month)->count();
        $this->concurrenciaUsuarios = Visitantes::all()->count();
    }
    public function render()
    {
        return view('livewire.dashboard-principal-component');
    }
}
