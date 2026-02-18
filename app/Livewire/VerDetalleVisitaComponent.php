<?php

namespace App\Livewire;

use App\Models\visitas;
use Livewire\Attributes\On;
use Livewire\Component;

class VerDetalleVisitaComponent extends Component
{
    public $showModal = false;
    public $visita = null;

    #[On('cargarDetalleVisita')]
    public function loadVisita($id)
    {
        $this->visita = visitas::with([
            'visitante.tiposDocumento',
            'empleados',
            'departamentos',
            'razonvisita',
            'archivos' // Traemos foto y firma de ESTA visita
        ])->findOrFail($id);

        $this->showModal = true;
    }
    public function render()
    {
        return view('livewire.ver-detalle-visita-component');
    }
}
