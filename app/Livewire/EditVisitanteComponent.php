<?php

namespace App\Livewire;

use App\Livewire\Forms\VisitanteForm;
use App\Models\Arl;
use App\Models\eps;
use App\Models\Paises;
use App\Models\TiposDocumento;
use App\Models\Visitantes;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class EditVisitanteComponent extends Component
{
    public $showModal = false;

    public VisitanteForm $visitanteForm;

    public function mount()
    {
        $this->visitanteForm->eps = eps::all();
        $this->visitanteForm->arl = Arl::all();
        $this->visitanteForm->tiposDocumento = TiposDocumento::all();
        $this->visitanteForm->paises = Paises::all();
    }

    #[On('cargarVisitante')]
    public function loadVisitante($id)
    {
        try {
            $visitante = Visitantes::findOrFail($id);
            $this->visitanteForm->cargarDatosVisitante($visitante);
            $this->showModal = true;
        } catch (\Throwable $th) {
            $this->showModal = true;
            session()->flash('error', 'No se pudo cargar la información del visitante.');
        }
    }

    public function update()
    {
        try {
            $this->visitanteForm->ActualizarVisitante();
            $this->showModal = false;
            $this->dispatch('visitanteActualizado')->to(ListarVisitantesComponent::class);
            session()->flash('success', 'Visitante actualizado correctamente.');
        } catch (\Throwable $th) {
            Log::error("Error actualizando visitante: " . $th->getMessage());
            session()->flash('error', 'No se pudo actualizar la información del visitante.');
        }
    }


    public function render()
    {
        return view('livewire.edit-visitante-component');
    }
}
