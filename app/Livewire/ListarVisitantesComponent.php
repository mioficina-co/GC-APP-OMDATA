<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\visitantes;

class ListarVisitantesComponent extends Component
{
    public function render()
    {
        $visitantes = visitantes::with('visitas', 'tiposDocumento', 'eps', 'arl')->get();
        return view('livewire.listar-visitantes-component', compact('visitantes'));
    }

    public function eliminar($id)
    {
        $visitante = visitantes::find($id);
        if ($visitante) {
            $visitante->delete();
        }
    }
    public function cambiarEstadoVisitante($id)
    {
        try {
            $visitante = visitantes::findOrFail($id);
            $visitante->update(['activo' => !$visitante->activo]);
            // session()->flash('mensaje', 'El estado del empleado ha sido actualizado.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado del empleado.');
        }
    }

}
