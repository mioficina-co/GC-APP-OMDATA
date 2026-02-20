<?php

namespace App\Livewire;

use App\Models\Visitas;
use Livewire\Component;
use App\Models\Visitantes;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class ListarVisitantesComponent extends Component
{
    use WithPagination;
    // Propiedad para controlar la visibilidad del modal
    public $showEditModal = false;
    // Propiedad para la búsqueda
    public $search = '';

    public $filterStatus = 'all'; // all, active, inactive

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        // Emitimos el evento al componente hijo de edición
        $this->dispatch('cargarVisitante', id: $id)->to(EditVisitanteComponent::class);
        $this->showEditModal = true;
    }

    #[On('visitanteActualizado')]
    public function render()
    {
        $visitantes = Visitantes::query()
            ->with(['ultimaVisita', 'ultimaFoto', 'tiposDocumento', 'eps', 'arl'])
            // 1. Subconsulta para detectar si el visitante está actualmente "dentro"
            // Seleccionamos la fecha_fin de la última visita
            ->addSelect([
                'fecha_fin_ultima' => Visitas::select('fecha_fin')
                    ->whereColumn('visitante_id', 'visitantes.id')
                    ->latest()
                    ->limit(1)
            ])
            // 2. Filtro de búsqueda
            ->where(function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
            })
            // 3. Filtro de Activos/Inactivos (Estado del perfil)
            ->when($this->filterStatus !== 'all', function ($query) {
                return $query->where('activo', $this->filterStatus === 'active');
            })
            // 4. Ordenación Crítica:
            // Primero: Los que tienen fecha_fin NULL en su última visita (están dentro)
            // Segundo: Los ingresos más recientes
            ->orderByRaw('fecha_fin_ultima IS NULL DESC')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.listar-visitantes-component', compact('visitantes'));
    }


    public function eliminar($id)
    {
        $visitante = Visitantes::find($id);

        if ($visitante) {
            $nombre = $visitante->nombre;
            $documento = $visitante->numero_documento;
            $telefono = $visitante->telefono;
            $email = $visitante->email;
            $eps = optional($visitante->eps)->nombre ?? 'No registrada';
            $arl = optional($visitante->arl)->nombre ?? 'No registrada';
            $fecha_creacion = $visitante->created_at->format('Y-m-d H:i:s');
            $fecha_eliminacion = now()->format('Y-m-d H:i:s');

            $pdf = Pdf::loadView('certificado', compact(
                'nombre',
                'documento',
                'telefono',
                'email',
                'eps',
                'arl',
                'fecha_creacion',
                'fecha_eliminacion'
            ))->setPaper('A4', 'portrait');

            // Definir el nombre del archivo
            $fileName = "certificado_eliminacion_{$visitante->numero_documento}.pdf";

            // Guardar el PDF en storage/app/public/certificados/
            Storage::disk('public')->put("certificados/{$fileName}", $pdf->output());

            $visitante->update(['deleted_by' => Auth::id()]);

            // Eliminar al visitante (si es necesario)
            $visitante->delete();

            // Retornar el PDF para descarga inmediata
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } else {
            session()->flash('error', 'Error: el visitante no existe.');
            return redirect()->back();
        }
    }


    public function cambiarEstadoVisitante($id)
    {
        try {
            $visitante = Visitantes::findOrFail($id);
            $visitante->update(['activo' => !$visitante->activo]);
            session()->flash('success', 'El estado del visitante ha sido actualizado.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado del visitante.');
        }
    }


    public function registrarSalida($visitanteId)
    {
        // Buscamos la visita activa de este visitante (la que no tiene fecha_fin)
        $visitaActiva = Visitas::where('visitante_id', $visitanteId)
            ->whereNull('fecha_fin')
            ->latest()
            ->first();

        if ($visitaActiva) {
            $this->dispatch('cargarVisitaSalida', id: $visitaActiva->id)->to(RegistroSalidaComponent::class);
        } else {
            session()->flash('error', 'No se encontró una visita activa para este visitante.');
        }
    }

    public function verDetalleVisitante($id)
    {
        $this->dispatch('cargarDetalleVisitante', id: $id)->to(DetalleVisitanteComponent::class);
    }
}
