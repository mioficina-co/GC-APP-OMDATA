<?php

namespace App\Livewire;
use App\Models\empleados;
use App\Models\departamentos;

use Livewire\Component;

class RegistroEmpleadoComponent extends Component
{
    public $nombre, $apellido, $documento, $departamento_id, $departamentos;

    public $archivoEmpleados;
    public $empleados;
    protected $rules = [
        'nombre' => 'required',
        'apellido' => 'required',
        'documento' => 'required',
        'departamento_id' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es requerido',
        'apellido.required' => 'El apellido es requerido',
        'documento.required' => 'El documento es requerido',
        'departamento_id.required' => 'El departamento es requerido',
    ];

    public function mount(empleados $empleados)
    {
        $this->departamentos = departamentos::all();
        $this->empleados = $empleados;
    }

    public function render()
    {
        return view('livewire.registro-empleado-component');
    }

    public function registroEmpleado()
    {
        $this->validate();
        $this->empleados->save();
        return redirect()->route('empleados.listar');
    }

}
