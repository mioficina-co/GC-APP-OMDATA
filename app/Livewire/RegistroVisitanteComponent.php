<?php

namespace App\Livewire;

use App\Models\departamentos;
use App\Models\empleados;
use App\Models\eps;
use App\Models\arl;
use App\Models\paises;
use App\Models\razonvisita;
use App\Models\tiposDocumento;
use App\Models\visitantes;
use App\Models\visitas;
use Livewire\Component;
use App\Repositories\visitasRepository;

class RegistroVisitanteComponent extends Component
{

    public $foto;
    public $firma;
    public $fecha_inicio;
    public $fecha_fin;
    public $empleado;
    public $razonvisita;
    public $departamento;
    public $nombre;
    public $apellido;
    public $numerodocumento;
    public $celular;
    public $email;
    public $genero;
    public $compania;
    public $placavehiculo;
    public $totalpersonas;
    public $pais;
    public $pertenencias;
    public $tipodocumento;
    public $contactoemergencia;
    public $numerocontactoemergencia;
    public $eps;
    public $arl;
    //clases
    private $visitante;
    private $visitas;

    public $tipoDocumento, $departamentos, $razones, $paises, $empleados, $eps_id, $arl_id;

    public function mount(visitantes $visitante, visitas $visitas)
    {
        $this->eps = eps::all();
        $this->arl = arl::all();
        $this->visitante = $visitante;
        $this->visitas = $visitas;

        $this->tipoDocumento = tiposDocumento::all();
        $this->departamentos = departamentos::all();
        $this->razones = razonvisita::all();
        $this->paises = paises::all();
        $this->empleados = empleados::where('activo', true)->get();
    }

    protected $rules = [
        'foto' => 'required', // Validación para asegurarse de que es una imagen en Base64
        'firma' => 'required', // Validación de Base64 y tipo de imagen
        'empleado' => 'required|exists:empleados,id',
        'razonvisita' => 'required|exists:razonvisitas,id',
        'departamento' => 'required|exists:departamentos,id',
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'tipodocumento' => 'required|exists:tipos_documento,id',
        'numerodocumento' => 'required|regex:/^\d{6,10}$/|unique:visitantes,numero_documento',
        'celular' => 'required|regex:/^\d{10}$/',
        'email' => 'required|email|max:255',
        'compania' => 'nullable|string|max:255',
        'placavehiculo' => 'nullable|string|max:10',
        'pais' => 'nullable|exists:paises,id',
        'contactoemergencia' => 'nullable|string|max:100',
        'numerocontactoemergencia' => 'nullable|regex:/^\d{7,15}$/',
        'eps_id' => 'required|exists:eps,id',
        'arl_id' => 'required|exists:arl,id',
    ];

    protected $messages = [
        'foto.required' => 'La foto es obligatoria.',
        'firma.required' => 'La firma es obligatoria.',
        'firma.string' => 'La firma debe ser una cadena de texto.',
        'firma.max' => 'La firma no puede exceder los 255 caracteres.',
        'empleado.required' => 'El empleado es obligatorio.',
        'empleado.exists' => 'El empleado seleccionado no es valido.',
        'razonvisita.required' => 'La razon de visita es obligatoria.',
        'razonvisita.exists' => 'La razon de visita seleccionada no es valida.',
        'departamento.required' => 'El departamento es obligatorio.',
        'departamento.exists' => 'El departamento seleccionado no es valido.',
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser una cadena de texto.',
        'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
        'apellido.required' => 'El apellido es obligatorio.',
        'apellido.string' => 'El apellido debe ser una cadena de texto.',
        'apellido.max' => 'El apellido no puede exceder los 100 caracteres.',
        'tipodocumento.required' => 'El tipo de documento es obligatorio.',
        'tipodocumento.exists' => 'El tipo de documento seleccionado no es valido.',
        'numerodocumento.required' => 'La cédula es obligatoria.',
        'numerodocumento.regex' => 'La cédula debe tener entre 6 y 10 dígitos numéricos.',
        'numerodocumento.unique' => 'Este número de cédula ya está registrado.',
        'celular.required' => 'El celular es obligatorio.',
        'celular.regex' => 'El celular debe ser un número de 10 dígitos.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
        'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
        'compania.string' => 'La compañía debe ser una cadena de texto.',
        'compania.max' => 'La compañía no puede exceder los 255 caracteres.',
        'placavehiculo.string' => 'La placa del vehículo debe ser una cadena de texto.',
        'placavehiculo.max' => 'La placa del vehículo no puede exceder los 10 caracteres.',
        'pais.exists' => 'El país seleccionado no es valido.',
        'contactoemergencia.string' => 'El contacto de emergencia debe ser una cadena de texto.',
        'contactoemergencia.max' => 'El contacto de emergencia no puede exceder los 100 caracteres.',
        'numerocontactoemergencia.regex' => 'El número de contacto de emergencia debe ser un número de 7 a 15 dígitos.',
        'eps_id.exists' => 'La EPS seleccionada no es valida.',
        'eps_id.required' => 'La EPS es obligatoria.',
        'arl_id.exists' => 'La ARL seleccionada no es valida.',
        'arl_id.required' => 'La ARL es obligatoria.',
    ];


    public function submitSignature(visitasRepository $visitasRepository)
    {
        $this->validate();
        $foto_visitante = $visitasRepository->tratamientoImagen($this->foto, '1051522305', 'foto');
        $firma_visitante = $visitasRepository->tratamientoImagen($this->firma, '1051522305', 'firma');
        // Guardar el visitante
        $visitante = visitantes::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'tipos_documento_id' => $this->tipodocumento,
            'numero_documento' => $this->numerodocumento,
            'genero' => $this->genero,
            'telefono' => $this->celular,
            'email' => $this->email,
            'compania' => $this->compania,
            'placa_vehiculo' => $this->placavehiculo,
            'nombre_contacto_emergencia' => $this->contactoemergencia,
            'numero_contacto_emergencia' => $this->numerocontactoemergencia,
            'pais_id' => $this->pais,
            'eps_id' => $this->eps_id,
            'arl_id' => $this->arl_id,
        ]);

        // Guardar la visita
        $visita = visitas::create([
            'visitante_id' => $visitante->id,
            'empleado_id' => $this->empleado,
            'departamento_id' => $this->departamento,
            'razon_id' => $this->razonvisita,
            'fecha_inicio' => now(),
            'fecha_fin' => $this->fecha_fin,
            'total_visitantes' => $this->totalpersonas,
            'pertenencias' => $this->pertenencias,
            'foto' => $foto_visitante,
            'firma_base64' => $firma_visitante,
            'acepta_politica' => true,
        ]);

        redirect()->route('visitantes.listar');
    }
    /**
     * Renders the Livewire component for the visit registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.registro-visitante-component', [
            'tipoDocumento' => $this->tipoDocumento,
            'empleados' => $this->empleados,
            'paises' => $this->paises,
            'razones' => $this->razones,
            'departamentos' => $this->departamentos,
            'eps' => $this->eps,
            'arl' => $this->arl,
        ]);
    }

    public function updatedEmpleado($empleado)
    {
        // Validar y buscar el departamento asociado al empleado seleccionado
        if ($empleado) {
            $empleadoSeleccionado = collect($this->empleados)->firstWhere('id', $empleado);
            $this->departamento = $empleadoSeleccionado['departamento_id'] ?? null;
        } else {
            $this->departamento = null; // Resetear el departamento si no hay empleado seleccionado
        }
    }

}
