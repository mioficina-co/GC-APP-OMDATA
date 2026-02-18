<?php

namespace App\Livewire;

use App\Models\AuditoriaDatos;
use App\Models\Empleados;
use App\Models\RazonVisita;
use App\Models\Visitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class EditVisitaComponent extends Component
{

    public $showModal = false;
    public $visitaId;

    // Campos editables del registro de visita
    public $empleado_id, $razon_id, $otra_razon_visita, $pertenencias, $fecha_fin;
    public $esOtro = false;

    // Listas para los selects
    public $empleados, $razones;

    public function mount()
    {
        $this->empleados = Empleados::where('activo', true)->orderBy('nombre')->get();
        $this->razones = RazonVisita::all();
    }

    #[On('cargarEdicionVisita')]
    public function loadVisita($id)
    {
        $visita = Visitas::findOrFail($id);

        $this->visitaId = $visita->id;
        $this->empleado_id = $visita->empleado_id;
        $this->razon_id = $visita->razon_id;
        $this->otra_razon_visita = $visita->otra_razon_visita;
        $this->pertenencias = $visita->pertenencias;

        // Formatear la fecha para el input datetime-local
        $this->fecha_fin = $visita->fecha_fin ? date('Y-m-d\TH:i', strtotime($visita->fecha_fin)) : null;

        $this->updatedRazonId($this->razon_id);
        $this->showModal = true;
    }

    public function updatedRazonId($value)
    {
        $razon = RazonVisita::find($value);
        $this->esOtro = ($razon && strtolower($razon->nombre) === 'otro');
    }

    public function update()
    {
        $this->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'razon_id' => 'required|exists:razonvisitas,id',
            'otra_razon_visita' => 'nullable|string|max:255',
            'pertenencias' => 'nullable|string',
            'fecha_fin' => 'nullable|date',
        ]);

        try {
            DB::transaction(function () {
                $visita = Visitas::findOrFail($this->visitaId);

                // 1. Capturar valores originales para Auditoría (Ley 1581)
                $camposAuditables = ['empleado_id', 'razon_id', 'otra_razon_visita', 'pertenencias', 'fecha_fin'];
                $valoresAntiguos = collect($visita->getOriginal())->only($camposAuditables)->toArray();

                // 2. Ejecutar actualización
                $visita->update([
                    'empleado_id' => $this->empleado_id,
                    'razon_id' => $this->razon_id,
                    'otra_razon_visita' => $this->otra_razon_visita,
                    'pertenencias' => $this->pertenencias,
                    'fecha_fin' => $this->fecha_fin,
                    'updated_by' => Auth::id()
                ]);

                // 3. Registrar qué cambió realmente
                $cambios = collect($visita->getChanges())->except(['updated_at', 'updated_by'])->toArray();

                if (count($cambios) > 0) {
                    AuditoriaDatos::create([
                        'user_id' => Auth::id(),
                        'evento' => 'updated_visit_log',
                        'model_type' => Visitas::class,
                        'model_id' => $visita->id,
                        'old_values' => array_intersect_key($valoresAntiguos, $cambios),
                        'new_values' => $cambios,
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent()
                    ]);
                }
            });

            $this->showModal = false;
            $this->dispatch('visitanteActualizado'); // Refresca el listado padre
            $this->dispatch('confirmacionGuardado'); // Lanza SweetAlert de éxito

        } catch (\Exception $e) {
            Log::error("Error editando visita: " . $e->getMessage());
            session()->flash('error', 'No se pudo actualizar el registro de la visita.');
        }
    }
    public function render()
    {
        return view('livewire.edit-visita-component');
    }
}
