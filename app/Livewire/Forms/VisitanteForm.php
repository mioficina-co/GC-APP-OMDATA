<?php

namespace App\Livewire\Forms;

use App\Models\AuditoriaDatos;
use App\Models\Visitantes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VisitanteForm extends Form
{

    //id del visitante
    public $visitanteId;
    // Campos del formulario
    public $nombre, $apellido, $numero_documento, $tipos_documento_id;
    #[Validate]
    public $telefono, $email, $compania, $placa_vehiculo, $rh;
    #[Validate]
    public $eps_id, $arl_id;

    public $pais_id;
    #[Validate]
    public $nombre_contacto_emergencia, $numero_contacto_emergencia;

    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'eps_id' => 'required|exists:eps,id',
            'arl_id' => 'required|exists:arl,id',
        ];
    }

    // Colecciones para los selects
    public $eps, $arl, $tiposDocumento, $paises;

    public function cargarDatosVisitante($visitante)
    {
        $this->visitanteId = $visitante->id;
        $this->telefono = $visitante->telefono;
        $this->email = $visitante->email;
        $this->compania = $visitante->compania;
        $this->placa_vehiculo = $visitante->placa_vehiculo;
        $this->rh = $visitante->rh;
        $this->eps_id = $visitante->eps_id;
        $this->arl_id = $visitante->arl_id;
        $this->pais_id = $visitante->pais_id;
        $this->nombre_contacto_emergencia = $visitante->nombre_contacto_emergencia;
        $this->numero_contacto_emergencia = $visitante->numero_contacto_emergencia;
    }
    public function ActualizarVisitante()
    {
        // 1. IMPORTANTE: Descomenta la validación.
        // Si la comentas, pueden entrar datos corruptos.
        $this->validate();

        return DB::transaction(function () {
            $visitante = Visitantes::findOrFail($this->visitanteId);

            // 2. Definimos exactamente qué campos son editables en este formulario
            // Estos son los únicos que deben ir al UPDATE y a la AUDITORÍA
            $camposEditables = [
                'telefono',
                'email',
                'eps_id',
                'arl_id',
                'nombre_contacto_emergencia',
                'numero_contacto_emergencia'
            ];

            // 3. Capturamos valores antiguos SOLO de los campos que vamos a cambiar
            $valoresAntiguos = collect($visitante->getOriginal())->only($camposEditables)->toArray();

            // 4. Preparamos los nuevos datos filtrando el objeto Form
            // Usamos 'only' en lugar de 'except' para mayor seguridad
            $datosNuevos = collect($this->all())->only($camposEditables)->toArray();

            // 5. Ejecutamos la actualización
            $visitante->update(
                array_merge($datosNuevos, ['updated_by' => Auth::id()])
            );

            // 6. Identificamos cambios reales para la auditoría (Ley 1581)
            $cambios = collect($visitante->getChanges())->except(['updated_at', 'updated_by'])->toArray();

            if (count($cambios) > 0) {
                AuditoriaDatos::create([
                    'user_id'    => Auth::id(),
                    'evento'     => 'updated',
                    'model_type' => Visitantes::class,
                    'model_id'   => $visitante->id,
                    // Guardamos el historial preciso de lo que cambió
                    'old_values' => array_intersect_key($valoresAntiguos, $cambios),
                    'new_values' => $cambios,
                    'ip'         => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }

            return true;
        });
    }
}
