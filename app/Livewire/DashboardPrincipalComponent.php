<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardPrincipalComponent extends Component
{

    public $visitantes;
    public $registrosMensuales;
    public $concurrenciaUsuarios;

    public function mount()
    {

        $this->visitantes = 101;
        $this->registrosMensuales = 288;
        $this->concurrenciaUsuarios = 56;
    }
    public function render()
    {
        return view('livewire.dashboard-principal-component');
    }
}
