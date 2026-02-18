<?php

namespace App\Livewire;

use App\Models\Empleados;
use App\Models\User;
use LIvewire\Attributes\On;
use Livewire\Component;

class PruebasComponent extends Component
{
    public function render()
    {
        return view('livewire.pruebas-component', [
            'users' => Empleados::all(),
        ]);
    }

    public $userId;

    // Método para eliminar usuario
    #[On('deleteUser')]
    public function deleteUser()
    {
        dd('dwedwedwe');
        // // $user = User::find($id);
        //     dd('dwedwedwe');
        //     // Enviar mensaje de éxito a la vista
        //     $this->dispatch('user-deleted', [
        //         'message' => 'Usuario eliminado correctamente.',
        //     ]);
    }

}
