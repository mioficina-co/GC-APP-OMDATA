<?php

namespace App\Livewire;

use App\Models\departamentos;
use App\Models\empleados;
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

    public $tipoDocumento, $departamentos, $razones, $paises, $empleados;

    public function mount(visitantes $visitante, visitas $visitas)
    {
        $this->visitante = $visitante;
        $this->visitas = $visitas;

        $this->tipoDocumento = tiposDocumento::all();
        $this->departamentos = departamentos::all();
        $this->razones = razonvisita::all();
        $this->paises = paises::all();
        $this->empleados = empleados::all();
    }

    protected $rules = [
        'foto' => 'required', // Validación para asegurarse de que es una imagen en Base64
        'firma' => 'required', // Validación de Base64 y tipo de imagen
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'empleado' => 'required|exists:empleados,id',
        'razonvisita' => 'required|exists:razonvisitas,id',
        'departamento' => 'required|exists:departamentos,id',
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'numerodocumento' => 'required|regex:/^\d{6,10}$/|unique:visitantes,numero_documento',
        'celular' => 'required|regex:/^\d{10}$/',
        'email' => 'required|email|max:255',
        'genero' => 'nullable|string|max:255',
        'compania' => 'nullable|string|max:255',
        'placavehiculo' => 'nullable|string|max:10',
        'totalpersonas' => 'required|integer|min:1',
        'pais' => 'required|exists:paises,id',
        'pertenencias' => 'nullable|string|max:500',
        'contactoemergencia' => 'nullable|string|max:100',
        'numerocontactoemergencia' => 'nullable|regex:/^\d{7,15}$/',
        'eps' => 'nullable|string|max:255',
        'arl' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'foto.required' => 'La foto es obligatoria.',
        'firma.required' => 'La firma es obligatoria.',
        'firma.string' => 'La firma debe ser una cadena de texto.',
        'firma.max' => 'La firma no puede exceder los 255 caracteres.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
        'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha.',
        'fecha_fin.required' => 'La fecha de fin es obligatoria.',
        'fecha_fin.date' => 'La fecha de fin debe ser una fecha.',
        'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
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
        'numerodocumento.required' => 'La cédula es obligatoria.',
        'numerodocumento.regex' => 'La cédula debe tener entre 6 y 10 dígitos numéricos.',
        'numerodocumento.unique' => 'Este número de cédula ya está registrado.',
        'celular.required' => 'El celular es obligatorio.',
        'celular.regex' => 'El celular debe ser un número de 10 dígitos.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
        'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
        'genero.string' => 'El género debe ser una cadena de texto.',
        'genero.max' => 'El género no puede exceder los 255 caracteres.',
        'compania.string' => 'La compañía debe ser una cadena de texto.',
        'compania.max' => 'La compañía no puede exceder los 255 caracteres.',
        'placavehiculo.string' => 'La placa del vehículo debe ser una cadena de texto.',
        'placavehiculo.max' => 'La placa del vehículo no puede exceder los 10 caracteres.',
        'total_personas.required' => 'El número de personas es obligatorio.',
        'total_personas.integer' => 'El número de personas debe ser un número entero.',
        'total_personas.min' => 'El número de personas debe ser al menos 1.',
        'pais.required' => 'El país es obligatorio.',
        'pais.exists' => 'El país seleccionado no es valido.',
        'pertenencias.string' => 'Las pertenencias deben ser una cadena de texto.',
        'pertenencias.max' => 'Las pertenencias no pueden exceder los 500 caracteres.',
        'contacto_emergencia.string' => 'El contacto de emergencia debe ser una cadena de texto.',
        'contacto_emergencia.max' => 'El contacto de emergencia no puede exceder los 100 caracteres.',
        'numero_contacto_emergencia.regex' => 'El número de contacto de emergencia debe ser un número de 7 a 15 dígitos.',
        'eps.string' => 'La EPS debe ser una cadena de texto.',
        'eps.max' => 'La EPS no puede exceder los 255 caracteres.',
        'arl.string' => 'La ARL debe ser una cadena de texto.',
        'arl.max' => 'La ARL no puede exceder los 255 caracteres.',
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
            'eps' => $this->eps,
            'arl' => $this->arl,
        ]);

        // Guardar la visita
        $visita = visitas::create([
            'visitante_id' => $visitante->id,
            'empleado_id' => $this->empleado,
            'departamento_id' => $this->departamento,
            'razon_id' => $this->razonvisita,
            'fecha_inicio' => $this->fecha_inicio,
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
        ]);
    }

}
