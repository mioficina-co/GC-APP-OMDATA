<?php

namespace App\Livewire;

use App\Models\PoliticaPrivacidad;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RegistroPoliticasComponent extends Component
{
    public $version, $contenido, $activa = true;

    protected $rules = [
        'version' => 'required|string|max:20',
        'contenido' => 'required|string',
    ];

    protected $messages = [
        'version.required' => 'La versión es obligatoria (Ej: v1.0).',
        'contenido.required' => 'El contenido legal es obligatorio.',
    ];

    public function registroPolitica()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Si la nueva política será la activa, desactivamos todas las anteriores
                if ($this->activa) {
                    PoliticaPrivacidad::where('activa', true)->update(['activa' => false]);
                }

                PoliticaPrivacidad::create([
                    'version' => $this->version,
                    'contenido' => $this->contenido,
                    'activa' => $this->activa,
                    'fecha_publicacion' => now(),
                ]);
            });

            session()->flash('success', 'Nueva política registrada y versionada correctamente.');
            $this->reset(['version', 'contenido', 'activa']);
            redirect()->route('politicas.listar');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.registro-politicas-component', [
            'politicas' => PoliticaPrivacidad::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
