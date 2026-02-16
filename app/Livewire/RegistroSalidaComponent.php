<?php

namespace App\Livewire;

use App\Models\visitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistroSalidaComponent extends Component
{
    public $showModal = false;
    public $visitaId;
    public $nombreVisitante;
    public $fechaEntrada;
    public $pertenencias;

    #[On('cargarVisitaSalida')]
    public function loadVisita($id)
    {
        $visita = Visitas::with('visitante')->findOrFail($id);


        $this->visitaId = $visita->id;
        $this->nombreVisitante = $visita->visitante->nombre . ' ' . $visita->visitante->apellido;
        $this->fechaEntrada = $visita->fecha_inicio;
        $this->pertenencias = $visita->pertenencias;

        $this->showModal = true;
    }

    public function confirmarSalida()
    {

        try {
            $visita = visitas::findOrFail($this->visitaId);

            $visita->update([
                'fecha_fin' => now(),
                'updated_by' => Auth::user()->id, // Auditoría
            ]);

            $this->showModal = false;

            // Notificar al listado para refrescar la tabla
            $this->dispatch('visitaActualizada')->to(ListarVisitasComponent::class);

            session()->flash('success', 'Salida registrada correctamente para: ' . $this->nombreVisitante);
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo registrar la salida.');
        }
    }

    public function render()
    {
        return view('livewire.registro-salida-component');
    }
}
