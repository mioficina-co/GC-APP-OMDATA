<?php

namespace App\Livewire;

use App\Models\Archivos;
use App\Models\Eps;
use App\Models\Arl;
use App\Models\Consentimiento;
use App\Models\Departamentos;
use App\Models\Empleados;
use App\Models\Paises;
use App\Models\PoliticaPrivacidad;
use App\Models\RazonVisita;
use App\Models\TiposDocumento;
use App\Models\Visitantes;
use App\Models\Visitas;
use Livewire\Component;
use App\Repositories\VisitasRepository;
use Illuminate\Support\Facades\Auth;
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
    public $rh;

    public $busquedaRealizada = false;
    public $visitanteEncontrado = false;

    //politica vigente
    public $politicaVigente;

    public $esOtro = false;
    public $otrorazonvisita;
    private $visitante;
    private $visitas;

    public $tipoDocumento, $departamentos, $razones, $paises, $empleados, $eps_id, $arl_id, $aceptaPolitica;

    public function mount(Visitantes $visitante, Visitas $visitas)
    {
        $this->eps = Eps::all();
        $this->arl = Arl::all();
        $this->visitante = $visitante;
        $this->visitas = $visitas;
        $this->tipoDocumento = TiposDocumento::all();
        $this->departamentos = Departamentos::all();
        $this->razones = RazonVisita::all();
        $this->paises = Paises::all();
        $this->empleados = Empleados::where('activo', true)->get();

        // Recuperamos la política activa para mostrarla en el formulario
        $this->politicaVigente = PoliticaPrivacidad::where('activa', true)->first();

        // Opcional: Si no hay política, podrías lanzar un error o cargar un texto por defecto
        if (!$this->politicaVigente) {
            $this->politicaVigente = (object)[
                'contenido' => 'No se ha configurado una política de privacidad activa. Por favor, contacte al administrador.',
                'version' => 'S/N'
            ];
        }
    }

    protected $rules = [
        'foto' => 'required',
        'firma' => 'required',
        'empleado' => 'required|exists:empleados,id',
        'razonvisita' => 'required|exists:razonvisitas,id',
        'otrorazonvisita' => 'nullable|required_if:esOtro,true|string|max:255',
        'departamento' => 'required|exists:departamentos,id',
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'tipodocumento' => 'required|exists:tipos_documento,id',
        'numerodocumento' => 'required|regex:/^\d{6,10}$/',
        'rh' => 'required|string|max:3',
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
        'otrorazonvisita.required_if' => 'La razon de visita es requerida.',
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
        'rh.required' => 'El RH es requerido.',
        'rh.string' => 'El RH debe ser una cadena de texto.',
        'rh.max' => 'El RH no debe exceder los 3 caracteres.',
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


    public function submitSignature(VisitasRepository $visitasRepository)
    {
        $this->validate();

        DB::transaction(function () use ($visitasRepository) {

            // 1. Obtener la política activa
            $politicaActiva = PoliticaPrivacidad::where('activa', true)->first();
            if (!$politicaActiva) throw new \Exception("No hay una política de privacidad activa.");



            $visitante = Visitantes::updateOrCreate(
                ['numero_documento' => $this->numerodocumento, 'tipos_documento_id' => $this->tipodocumento],
                [
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'rh' => $this->rh,
                    'telefono' => $this->celular,
                    'email' => $this->email,
                    'compania' => $this->compania,
                    'placa_vehiculo' => $this->placavehiculo,
                    'nombre_contacto_emergencia' => $this->contactoemergencia,
                    'numero_contacto_emergencia' => $this->numerocontactoemergencia,
                    'pais_id' => $this->pais,
                    'eps_id' => $this->eps_id,
                    'arl_id' => $this->arl_id,
                    'politica_aceptada_id' => $politicaActiva->id,
                    'fecha_aceptacion_politica' => now(),
                    'ip_aceptacion' => request()->ip(),
                    'user_agent_aceptacion' => request()->userAgent(),
                    'created_by' => Auth::id(), // Si hay un usuario logueado (ej. Recepcionista)
                ]
            );

            // 3. Registrar el Consentimiento (Evidencia legal robusta)
            Consentimiento::create([
                'visitante_id' => $visitante->id,
                'politica_id' => $politicaActiva->id,
                'acepta' => true,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // 4. Crear la Visita
            $visita = Visitas::create([
                'visitante_id' => $visitante->id,
                'empleado_id' => $this->empleado,
                'departamento_id' => $this->departamento,
                'razon_id' => $this->razonvisita,
                'otra_razon_visita' => $this->otrorazonvisita,
                'fecha_inicio' => now(),
                'total_visitantes' => $this->totalpersonas ?? 1,
                'pertenencias' => $this->pertenencias,
                'created_by' => Auth::id(),
            ]);

            // 5. Tratamiento de Archivos (Foto y Firma)
            $foto_ruta = $visitasRepository->tratamientoImagen($this->foto, $this->numerodocumento, 'foto');
            $firma_ruta = $visitasRepository->tratamientoImagen($this->firma, $this->numerodocumento, 'firma');

            Archivos::create([
                'visitante_id' => $visitante->id,
                'visita_id' => $visita->id,
                'tipo' => 'foto',
                'ruta' => $foto_ruta,
                'nombre_original' => "foto_{$this->numerodocumento}.png",
                'mime_type' => 'image/png'
            ]);

            Archivos::create([
                'visitante_id' => $visitante->id,
                'visita_id' => $visita->id,
                'tipo' => 'firma',
                'ruta' => $firma_ruta,
                'nombre_original' => "firma_{$this->numerodocumento}.png",
                'mime_type' => 'image/png'
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

    /**
     * HOOKS: Se disparan cuando cambian los campos clave
     */
    public function updatedTipodocumento()
    {
        $this->buscarOResetearVisitante();
    }

    public function updatedNumerodocumento()
    {
        $this->buscarOResetearVisitante();
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
            'rh',
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
            'busquedaRealizada',
        ]);

        $this->dispatch('resetFirma');
        $this->dispatch('resetFoto');
    }


    /**
     * Lógica central de búsqueda y limpieza
     */
    private function buscarOResetearVisitante()
    {
        // Resetear estados y campos cada vez que cambie algo
        $this->busquedaRealizada = false;
        $this->visitanteEncontrado = false;
        // 1. Resetear todos los campos del perfil (menos los de búsqueda)
        $this->reset([
            'nombre',
            'apellido',
            'rh',
            'celular',
            'email',
            'compania',
            'placavehiculo',
            'contactoemergencia',
            'numerocontactoemergencia',
            'pais',
            'eps_id',
            'arl_id'
        ]);

        // 2. Solo buscar si AMBOS campos tienen valor
        if ($this->numerodocumento && $this->tipodocumento) {

            $visitante = Visitantes::where('numero_documento', $this->numerodocumento)
                ->where('tipos_documento_id', $this->tipodocumento)
                ->first();

            $this->busquedaRealizada = true; // Marcamos que se hizo el intento

            if ($visitante) {

                $this->visitanteEncontrado = true;
                // Rellenar campos si el visitante existe
                $this->nombre = $visitante->nombre;
                $this->apellido = $visitante->apellido;
                $this->rh = $visitante->rh;
                $this->celular = $visitante->telefono;
                $this->email = $visitante->email;
                $this->compania = $visitante->compania;
                $this->placavehiculo = $visitante->placa_vehiculo;
                $this->contactoemergencia = $visitante->nombre_contacto_emergencia;
                $this->numerocontactoemergencia = $visitante->numero_contacto_emergencia;
                $this->pais = $visitante->pais_id;
                $this->eps_id = $visitante->eps_id;
                $this->arl_id = $visitante->arl_id;
            }
        }
    }


    public function updatedRazonvisita($value)
    {
        $razon = RazonVisita::find($value);

        // Si el nombre de la razón es "Otro", habilita el campo adicional
        $this->esOtro = $razon && strtolower($razon->nombre) === 'otro';

        // Si cambia a otra opción diferente, limpia el campo adicional
        if (!$this->esOtro) {
            $this->otrorazonvisita = null;
        }
    }
}
