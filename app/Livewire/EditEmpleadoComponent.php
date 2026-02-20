<?php

namespace App\Livewire;

use App\Models\Departamentos;
use App\Models\Empleados;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditEmpleadoComponent extends Component
{

    public $showModal = false;
    public $empleadoId, $nombre, $apellido, $documento, $departamento_id;
    public $departamentos;

    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'documento' => [
                'required',
                Rule::unique('empleados', 'documento')->ignore($this->empleadoId),
            ],
            'departamento_id' => 'required',
        ];
    }

    protected $messages = [
        'nombre.required' => 'El nombre es requerido.',
        'apellido.required' => 'El apellido es requerido.',
        'documento.required' => 'El documento es requerido.',
        'documento.unique' => 'El documento ya está registrado.',
        'departamento_id.required' => 'El departamento es requerido.',
    ];

    // Escucha el evento enviado desde el padre
    #[On('cargarEmpleado')]
    public function loadEmpleado($id)
    {
        $empleado = Empleados::findOrFail($id);
        $this->empleadoId = $empleado->id;
        $this->nombre = $empleado->nombre;
        $this->apellido = $empleado->apellido;
        $this->documento = $empleado->documento;
        $this->departamento_id = $empleado->departamento_id;

        $this->showModal = true; // Abre el modal
    }

    public function mount()
    {
        $this->departamentos = Departamentos::all();
    }

    public function update()
    {
        $this->validate();

        try {
            $empleado = Empleados::find($this->empleadoId);
            $empleado->update([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'documento' => $this->documento,
                'departamento_id' => $this->departamento_id,
                'updated_by' => Auth::id(), // Auditoría
            ]);

            $this->showModal = false;
        } catch (\Exception $e) {
            return redirect()->route('empleados.listar');
        }

        // Notificar al componente lista que se actualizó algo
        $this->dispatch('empleadoActualizado')->to(ListarEmpleadosComponent::class);
    }
    public function render()
    {
        return view('livewire.edit-empleado-component');
    }
}
