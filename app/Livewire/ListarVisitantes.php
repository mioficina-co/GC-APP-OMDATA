<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\visitantes;

class ListarVisitantes extends Component
{
    public function render()
    {
        $visitantes = visitantes::all();
        return view('livewire.listar-visitantes', compact('visitantes'));
    }

    public function eliminar($id)
    {
        $visitante = visitantes::find($id);
        if ($visitante) {
            $visitante->delete();
        }
    }

}
