<?php

namespace App\Livewire;

use App\Models\AuditoriaDatos;
use App\Models\PoliticaPrivacidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListarPoliticasComponent extends Component
{
    use WithPagination;

    public $showModal = false;

    public $politicaActivaId;

    public $search = '';

    // Abrir modal para crear nueva o editar
    public function openModal($id = null)
    {
        $this->dispatch('cargarPolitica', id: $id)->to(EditPoliticasComponent::class);
        $this->showModal = true;
    }


    public function mount()
    {
        // Al cargar, identificamos cuál es la política vigente en la DB
        $this->politicaActivaId = PoliticaPrivacidad::where('activa', true)->value('id');
    }

    // Reiniciar paginación cuando el usuario escribe
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('politicaActualizada')]
    public function render()
    {
        $politicas = PoliticaPrivacidad::query()
            ->where(function ($query) {
                $query->where('version', 'like', '%' . $this->search . '%')
                    ->orWhere('contenido', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.listar-politicas-component', [
            'politicas' => $politicas
        ]);
    }

    /**
     * Hook de Livewire 3: Se ejecuta al cambiar el Radio/Switch
     */
    public function updatedPoliticaActivaId($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // 1. Desactivar la política que estaba vigente
                PoliticaPrivacidad::where('activa', true)->update(['activa' => false]);

                // 2. Activar la nueva seleccionada
                PoliticaPrivacidad::where('id', $id)->update(['activa' => true]);
            });

            session()->flash('success', 'La política seleccionada ahora es la única vigente.');
        } catch (\Exception $e) {
            // Revertir el ID visual en caso de error
            $this->politicaActivaId = PoliticaPrivacidad::where('activa', true)->value('id');
            session()->flash('error', 'No se pudo actualizar la política.');
        }
    }



    public function eliminar($id)
    {

        // 1. Intentar encontrar el registro o avisar si ya no existe
        $politica = PoliticaPrivacidad::find($id);

        if (!$politica) {
            session()->flash('error', 'La política ya no existe o fue eliminada por otro usuario.');
            return;
        }

        if ($politica->activa) {
            session()->flash('error', 'No puedes eliminar la política activa. Primero activa otra.');
            return;
        }

        try {
            DB::transaction(function () use ($politica) {
                // 3. Capturar valores para la auditoría antes de borrar
                // Guardamos la versión y el contenido para tener evidencia de qué se borró
                $valoresAntiguos = [
                    'version' => $politica->version,
                    'contenido' => $politica->contenido,
                    'fecha_publicacion' => $politica->fecha_publicacion,
                ];

                // 4. Actualizar quién borra y ejecutar Soft Delete
                $politica->update([
                    'deleted_by' => Auth::id()
                ]);

                $politica->delete(); // Esto activa el deleted_at (SoftDelete)

                // 5. Crear el registro en la tabla de auditoría (Cumplimiento Ley 1581)
                AuditoriaDatos::create([
                    'user_id'    => Auth::id(),
                    'evento'     => 'deleted', // Marcamos el evento como eliminación
                    'model_type' => PoliticaPrivacidad::class,
                    'model_id'   => $politica->id,
                    'old_values' => $valoresAntiguos, // Evidencia del texto legal que desaparece
                    'new_values' => ['deleted_at' => now()],
                    'ip'         => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            });

            session()->flash('success', 'Versión de política archivada y auditada correctamente.');
        } catch (\Throwable $th) {
            // Logueamos el error para soporte técnico
            Log::error("Error eliminando política: " . $th->getMessage());
            session()->flash('error', 'Ocurrió un error técnico al intentar eliminar la política.');
        }
    }
}
