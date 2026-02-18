<?php

namespace App\Livewire;

use App\Models\Visitantes;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleVisitanteComponent extends Component
{

    public $showModal = false;
    public $visitante = null;

    #[On('cargarDetalleVisitante')]
    public function loadVisitante($id)
    {
        // Cargamos el visitante con todas las relaciones necesarias para el detalle
        $this->visitante = Visitantes::with([
            'tiposDocumento',
            'eps',
            'arl',
            'ultimaVisita.razonvisita',
            'ultimaVisita.empleados',
            'ultimaVisita.departamentos',
            'ultimaFoto',
            'politicaAceptada'
        ])->findOrFail($id);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.detalle-visitante-component');
    }
}
