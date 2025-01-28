<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empleados;

class ListarEmpleadosComponent extends Component
{
    public function render()
    {
        $empleados = Empleados::all();
        return view('livewire.listar-empleados-component', compact('empleados'));
    }

    public function eliminar($id)
    {
        $empleado = Empleados::find($id);
        if ($empleado) {
            $empleado->delete();
        }
    }


    // Método generalizado para activar y desactivar
    public function cambiarEstadoEmpleado($id)
    {
        try {
            $empleado = Empleados::findOrFail($id);
            $empleado->update(['activo' => !$empleado->activo]);
            session()->flash('success', 'El estado del empleado ha sido actualizado.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado del empleado.');
        }
    }
}
