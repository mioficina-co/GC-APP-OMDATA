<?php

namespace App\Livewire;

use App\Models\empleados;
use App\Models\departamentos;
use League\Csv\Reader;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
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
        empleados::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'documento' => $this->documento,
            'departamento_id' => $this->departamento_id,
        ]);
        session()->flash('success', 'Empleado registrado exitosamente.');
        redirect()->route('empleados.listar');
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
            session()->flash('error', 'Por favor seleccione un archivo.');
            return;
        }

        // Validar la extensión del archivo
        $extension = $this->archivoEmpleados->getClientOriginalExtension();
        if (strtolower($extension) !== 'csv') {
            session()->flash('error', 'El formato del archivo no es permitido. Solo se admiten archivos CSV.');
            return;
        }

        DB::beginTransaction();

        try {
            $csv = Reader::createFromPath($this->archivoEmpleados->getRealPath(), 'r');
            $csv->setHeaderOffset(0);

            $allowedHeaders = [
                'Nombres' => 'nombres',
                'Apellidos' => 'apellidos',
                'Documento' => 'documento',
                'Departamento' => 'departamento_id',
            ];

            $headers = $csv->getHeader();
            $formattedHeaders = [];

            // Validar encabezados del archivo CSV
            foreach ($headers as $header) {
                if (array_key_exists($header, $allowedHeaders)) {
                    $formattedHeaders[] = $allowedHeaders[$header];
                } else {
                    $encabezadosPermitidos = implode(', ', array_keys($allowedHeaders));
                    session()->flash('error', "El encabezado '{$header}' no es válido. Encabezados permitidos: {$encabezadosPermitidos}.");
                    DB::rollBack();
                    return;
                }
            }

            $records = $csv->getRecords();
            $errores = [];
            $duplicados = [];
            $procesados = 0;

            // Obtener los documentos existentes en la base de datos
            $existingDocuments = empleados::pluck('documento')->toArray();

            foreach ($records as $index => $record) {
                $record = array_combine($formattedHeaders, $record);

                // Validar duplicados
                if (in_array($record['documento'], $existingDocuments)) {
                    $duplicados[] = [
                        'fila' => $index + 1,
                        'documento' => $record['documento'],
                    ];
                    continue;
                }

                // Validar el registro
                $validator = Validator::make(
                    $record,
                    [
                        'nombres' => 'required|string|max:255',
                        'apellidos' => 'required|string|max:255',
                        'documento' => 'required|string|max:20',
                        'departamento_id' => 'required|exists:departamentos,id',
                    ]
                );

                if ($validator->fails()) {
                    $errores[] = [
                        'fila' => $index + 1,
                        'errores' => $validator->errors()->all(),
                    ];
                    continue;
                }

                // Insertar los datos en la base de datos
                empleados::create([
                    'nombre' => $record['nombres'],
                    'apellido' => $record['apellidos'],
                    'documento' => $record['documento'],
                    'departamento_id' => $record['departamento_id'],
                ]);

                $procesados++;
            }

            DB::commit();

            $mensajes = [];

            if (!empty($duplicados)) {
                $duplicadosDesglosados = collect($duplicados)->map(function ($duplicado) {
                    return "Fila {$duplicado['fila']}: Documento {$duplicado['documento']}";
                })->implode('<br>');
                $mensajes[] = "Registros duplicados encontrados:<br>{$duplicadosDesglosados}";
            }

            if (!empty($errores)) {
                $erroresDesglosados = collect($errores)->map(function ($error) {
                    $detallesErrores = implode('; ', $error['errores']);
                    return "Fila {$error['fila']}: {$detallesErrores}";
                })->implode('<br>');
                $mensajes[] = "Errores de validación:<br>{$erroresDesglosados}";
            }

            if ($procesados > 0) {
                $mensajes[] = "Se procesaron correctamente $procesados registros.";
            }

            if (empty($mensajes)) {
                session()->flash('error', 'Todos los registros ya existen en la base de datos.');
            } else {
                session()->flash('info', implode('<hr>', $mensajes));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Hubo un error al procesar el archivo: ' . $e->getMessage());
        }
    }
}
