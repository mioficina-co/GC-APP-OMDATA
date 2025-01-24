<?php

namespace App\Livewire;
use App\Models\empleados;
use App\Models\departamentos;
use League\Csv\Reader;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;

class RegistroEmpleadoComponent extends Component
{
    use WithFileUploads;
    public $nombre, $apellido, $documento, $departamento_id, $departamentos;

    public $archivoEmpleados;
    public $empleados;
    protected $rules = [
        'nombre' => 'required',
        'apellido' => 'required',
        'documento' => 'required|unique:empleados,documento',
        'departamento_id' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es requerido',
        'apellido.required' => 'El apellido es requerido',
        'documento.required' => 'El documento es requerido',
        'documento.unique' => 'El documento ya existe',
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
        Empleados::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'documento' => $this->documento,
            'departamento_id' => $this->departamento_id,
        ]);
        session()->flash('success', 'Empleado registrado exitosamente.');
    }

    public function updatedarchivoEmpleados()
    {
        if ($this->archivoEmpleados) {
            // Llamar a una función cuando el archivo es seleccionado
            $this->cargaMasiva();
        }
    }

    public function cargaMasiva()
    {

        if (!$this->archivoEmpleados) {
            session()->flash('error', 'Por favor seleccione un archivo CSV.');
            return;
        }

        // Cargar el archivo CSV
        $csv = Reader::createFromPath($this->archivoEmpleados->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Asumir que la primera fila es el encabezado

        // Validar los datos en cada fila
        $records = $csv->getRecords();


        foreach ($records as $record) {
            $validator = Validator::make($record, [
                'Nombres' => 'required|string',
                'Apellidos' => 'required|string',
                'Documento' => 'required|string|unique:empleados,documento',
                'Departamento' => 'required|exists:departamentos,id',
            ]);

            if ($validator->fails()) {
                // Si alguna fila no es válida, se puede guardar los errores
                session()->flash('error', 'Error en la fila: ' . json_encode($record));
                return;
            }

            // Si es válido, registrar el empleado
            $departamento = departamentos::where('id', $record['Departamento'])->first();

            $deptar = empleados::create([
                'nombre' => $record['Nombres'],
                'apellido' => $record['Apellidos'],
                'documento' => $record['Documento'],
                'departamento_id' => $departamento->id,
            ]);

        }

        session()->flash('success', 'Empleados registrados correctamente.');
    }

}
