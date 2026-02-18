<?php

namespace App\Livewire;

use App\Models\Visitas;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListarVisitasComponent extends Component
{
    use WithPagination;

    // Filtros
    public $search = '';
    public $status = 'all'; // all, ongoing, finished
    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        // Por defecto, mostrar visitas de hoy
        $this->dateFrom = Carbon::today()->format('Y-m-d');
        $this->dateTo = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatus()
    {
        $this->resetPage();
    }
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    public function updatingDateTo()
    {
        $this->resetPage();
    }
    #[On('visitaActualizada')]
    public function render()
    {

        $query = Visitas::query()
            ->with(['visitante', 'empleados', 'razonvisita', 'departamentos', 'archivos'])
            ->where(function ($q) {
                $q->whereHas('visitante', function ($v) {
                    $v->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('apellido', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('empleados', function ($e) {
                        $e->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%');
                    });
            });

        // Filtro por Estado
        if ($this->status === 'ongoing') {
            $query->whereNull('fecha_fin');
        } elseif ($this->status === 'finished') {
            $query->whereNotNull('fecha_fin');
        }

        // Filtro por Rango de Fechas
        if ($this->dateFrom) {
            $query->whereDate('fecha_inicio', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('fecha_inicio', '<=', $this->dateTo);
        }

        $visitas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.listar-visitas-component', compact('visitas'));
    }

    public function registrarSalida($visitaId)
    {

        if ($visitaId) {
            $this->dispatch('cargarVisitaSalida', id: $visitaId)->to(RegistroSalidaComponent::class);
        } else {
            session()->flash('error', 'No se encontró una visita activa para este visitante.');
        }
    }

    public function editarVisita($id)
    {
        $this->dispatch('cargarEdicionVisita', id: $id)->to(EditVisitaComponent::class);
    }

    public function verDetalleVisita($id)
    {
        // Disparamos el evento hacia el componente de detalle
        $this->dispatch('cargarDetalleVisita', id: $id)->to(VerDetalleVisitaComponent::class);
    }
}
