<?php

namespace App\Livewire;

use App\Models\PoliticaPrivacidad;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditPoliticasComponent extends Component
{
    public $showModal = false;
    public $politicaId, $version, $contenido, $activa = false;

    protected function rules()
    {
        return [
            'version' => 'required|string|max:50',
            'contenido' => 'required|string',
        ];
    }

    #[On('cargarPolitica')]
    public function loadPolitica($id = null)
    {
        $this->resetErrorBag();
        $this->reset(['politicaId', 'version', 'contenido', 'activa']);

        if ($id) {
            $politica = PoliticaPrivacidad::findOrFail($id);
            $this->politicaId = $politica->id;
            $this->version = $politica->version;
            $this->contenido = $politica->contenido;
            $this->activa = $politica->activa;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->politicaId) {
            $politica = PoliticaPrivacidad::find($this->politicaId);
            $politica->update([
                'version' => $this->version,
                'contenido' => $this->contenido,
                'updated_by' => Auth::id(),
            ]);
        } else {
            // Si es nueva y se marca como activa, el sistema debe desactivar la anterior
            if ($this->activa) {
                PoliticaPrivacidad::where('activa', true)->update(['activa' => false]);
            }

            PoliticaPrivacidad::create([
                'version' => $this->version,
                'contenido' => $this->contenido,
                'activa' => $this->activa,
                'fecha_publicacion' => now(),
                'created_by' => Auth::id(),
            ]);
        }

        $this->showModal = false;
        $this->dispatch('politicaActualizada')->to(ListarPoliticasComponent::class);
        session()->flash('success', 'Política guardada correctamente.');
    }
    public function render()
    {
        return view('livewire.edit-politicas-component');
    }
}
