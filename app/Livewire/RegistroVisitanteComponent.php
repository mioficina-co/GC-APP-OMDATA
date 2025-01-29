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
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

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

    private $visitante;
    private $visitas;

    public $tipoDocumento, $departamentos, $razones, $paises, $empleados, $eps_id, $arl_id, $aceptaPolitica;

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
        'foto' => 'required',
        'firma' => 'required',
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
        'pais' => 'required|exists:paises,id',
        'contactoemergencia' => 'nullable|string|max:100',
        'numerocontactoemergencia' => 'nullable|regex:/^\d{7,15}$/',
        'eps_id' => 'required|exists:eps,id',
        'arl_id' => 'required|exists:arl,id',
        'aceptaPolitica' => 'required|accepted',
    ];

    protected $messages = [
        'foto.required' => 'La foto es requerida.',
        'firma.required' => 'La firma es requerida.',
        'empleado.required' => 'El empleado es requerido.',
        'empleado.exists' => 'El empleado seleccionado no existe.',
        'razonvisita.required' => 'La razón de visita es requerida.',
        'razonvisita.exists' => 'La razón de visita seleccionada no existe.',
        'departamento.required' => 'El departamento es requerido.',
        'departamento.exists' => 'El departamento seleccionado no existe.',
        'nombre.required' => 'El nombre es requerido.',
        'nombre.string' => 'El nombre debe ser una cadena de texto.',
        'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
        'apellido.required' => 'El apellido es requerido.',
        'apellido.string' => 'El apellido debe ser una cadena de texto.',
        'apellido.max' => 'El apellido no debe exceder los 100 caracteres.',
        'tipodocumento.required' => 'El tipo de documento es requerido.',
        'tipodocumento.exists' => 'El tipo de documento seleccionado no existe.',
        'numerodocumento.required' => 'El número de documento es requerido.',
        'numerodocumento.regex' => 'El número de documento debe tener entre 6 y 10 dígitos.',
        'numerodocumento.unique' => 'El número de documento ya está registrado.',
        'celular.required' => 'El número de celular es requerido.',
        'celular.regex' => 'El número de celular debe tener 10 dígitos.',
        'email.required' => 'El correo electrónico es requerido.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
        'compania.nullable' => 'La compañía es opcional.',
        'compania.string' => 'La compañía debe ser una cadena de texto.',
        'compania.max' => 'El nombre de la compañía no debe exceder los 255 caracteres.',
        'placavehiculo.nullable' => 'La placa del vehículo es opcional.',
        'placavehiculo.string' => 'La placa del vehículo debe ser una cadena de texto.',
        'placavehiculo.max' => 'La placa del vehículo no debe exceder los 10 caracteres.',
        'pais.required' => 'El país es requerido.',
        'pais.exists' => 'El país seleccionado no existe.',
        'contactoemergencia.nullable' => 'El contacto de emergencia es opcional.',
        'contactoemergencia.string' => 'El contacto de emergencia debe ser una cadena de texto.',
        'contactoemergencia.max' => 'El contacto de emergencia no debe exceder los 100 caracteres.',
        'numerocontactoemergencia.nullable' => 'El número de contacto de emergencia es opcional.',
        'numerocontactoemergencia.regex' => 'El número de contacto de emergencia debe tener entre 7 y 15 dígitos.',
        'eps_id.required' => 'La EPS es requerida.',
        'eps_id.exists' => 'La EPS seleccionada no existe.',
        'arl_id.required' => 'La ARL es requerida.',
        'arl_id.exists' => 'La ARL seleccionada no existe.',
        'aceptaPolitica.required' => 'Debe aceptar la política.',
        'aceptaPolitica.accepted' => 'Debe aceptar la política de privacidad.',
    ];


    public function submitSignature(visitasRepository $visitasRepository)
    {
        $this->validate();

        DB::transaction(function () use ($visitasRepository) {
            $foto_visitante = $visitasRepository->tratamientoImagen($this->foto, $this->numerodocumento, 'foto');
            $firma_visitante = $visitasRepository->tratamientoImagen($this->firma, $this->numerodocumento, 'firma');

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

            visitas::create([
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
        });

        $this->resetForm();
        $this->dispatch('confirmacionGuardado');
    }

    #[Layout('components.layouts.visitante')]
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
        if ($empleado) {
            $empleadoSeleccionado = collect($this->empleados)->firstWhere('id', $empleado);
            $this->departamento = $empleadoSeleccionado['departamento_id'] ?? null;
        } else {
            $this->departamento = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'foto',
            'firma',
            'fecha_inicio',
            'fecha_fin',
            'empleado',
            'razonvisita',
            'departamento',
            'nombre',
            'apellido',
            'numerodocumento',
            'celular',
            'email',
            'genero',
            'compania',
            'placavehiculo',
            'totalpersonas',
            'pais',
            'pertenencias',
            'tipodocumento',
            'contactoemergencia',
            'numerocontactoemergencia',
            'eps_id',
            'arl_id',
            'aceptaPolitica',
        ]);

        $this->dispatch('resetFirma');
        $this->dispatch('resetFoto');
    }

}
