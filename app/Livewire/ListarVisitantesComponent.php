<?php

namespace App\Livewire;

use App\Models\visitas;
use Livewire\Component;
use App\Models\visitantes;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ListarVisitantesComponent extends Component
{
    use WithPagination;

    public function render()
    {
        $visitantes = visitantes::with('visitas', 'tiposDocumento', 'eps', 'arl')->orderBy('id', 'desc')->paginate(5);
        return view('livewire.listar-visitantes-component', compact('visitantes'));
    }


    public function eliminar($id)
    {
        $visitante = visitantes::find($id);

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
                'nombre', 'documento', 'telefono', 'email', 'eps', 'arl', 'fecha_creacion', 'fecha_eliminacion'
            ))->setPaper('A4', 'portrait');

            // Definir el nombre del archivo
            $fileName = "certificado_eliminacion_{$visitante->numero_documento}.pdf";

            // Guardar el PDF en storage/app/public/certificados/
            Storage::disk('public')->put("certificados/{$fileName}", $pdf->output());

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
            $visitante = visitantes::findOrFail($id);
            $visitante->update(['activo' => !$visitante->activo]);
            session()->flash('success', 'El estado del visitante ha sido actualizado.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado del visitante.');
        }
    }


    public function registrarSalida($id)
    {
        try {
            $visitas = visitas::findOrFail($id);

            $visitas->update([
                'fecha_fin' => now()
            ]);

            session()->flash('success', 'Se registró la hora de salida correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar la hora de salida.');
        }
    }

}
