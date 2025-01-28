<div>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>
                        <button class="bg-red-500 text-dark px-4 py-2 rounded"
                            wire:click='$dispatch("confirm-delete")'>
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @script
        <script>
            $wire.on('confirm-delete', () => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $wire.dispatch('deleteUser');
                    }
                });
            });
        </script>
    @endscript

    {{-- <script>
        document.addEventListener('livewire:init', () => {
            //muestra el modal de confirmación de eliminación
            Livewire.on('borrarActivo', (event) => {
                Livewire.dispatch('confirm-delete');
            });
        });

        document.addEventListener('livewire:init', () => {
            //muestra el modal de confirmación de eliminación
            Livewire.on('confirm-delete', (event) => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Livewire.dispatch('deleteUser');
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
        // Escuchar el evento personalizado 'confirm-delete'
        document.addEventListener('confirm-delete', event => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esta acción.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteUser');
                }
            });
        });


        // Escuchar el evento de eliminación exitosa
        window.addEventListener('user-deleted', event => {
            Swal.fire(
                'Eliminado!',
                event.detail.message,
                'success'
            );

            Swal.fire({
                title: "Auto close alert!",
                html: "I will close in <b></b> milliseconds.",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        });
    </script> --}}
</div>
