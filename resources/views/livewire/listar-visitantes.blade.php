<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <svg class="h-6 w-6 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M9 12h6m-3-6v6" />
            </svg>
            Lista de Visitantes
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="border-b px-4 py-3">ID</th>
                        <th class="border-b px-4 py-3">Nombre</th>
                        <th class="border-b px-4 py-3">Apellido</th>
                        <th class="border-b px-4 py-3">Documento</th>
                        <th class="border-b px-4 py-3">Teléfono</th>
                        <th class="border-b px-4 py-3">Email</th>
                        <th class="border-b px-4 py-3">Género</th>
                        <th class="border-b px-4 py-3">Placa Vehículo</th>
                        <th class="border-b px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($visitantes as $visitante)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->nombre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->apellido }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->numero_documento }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->telefono }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->genero }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->placa_vehiculo }}</td>
                            {{-- <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button
                                        class="flex items-center text-indigo-600 hover:text-indigo-800 focus:outline-none"
                                        wire:click="editar({{ $visitante->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L8 9.172V11h1.828l6.586-6.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd"
                                                d="M3 8.586V17h8.414l6.586-6.586-8.414-8.414L3 8.586z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Editar
                                    </button>
                                    <button class="flex items-center text-red-600 hover:text-red-800 focus:outline-none"
                                        wire:click="eliminar({{ $visitante->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M6.707 4.293A1 1 0 016 5v12a1 1 0 001 1h6a1 1 0 001-1V5a1 1 0 00-.293-.707l-1-1A1 1 0 0012 3H8a1 1 0 00-.707.293l-1 1zM9 7h2v8H9V7z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </div>
                            </td> --}}
                            <td class="text-center">
                                <ul class="flex items-center justify-center gap-2">
                                    <li><a href="javascript:;" x-tooltip="Editar">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-success">
                                                <path
                                                    d="M15.2869 3.15178L14.3601 4.07866L5.83882 12.5999L5.83881 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L4.19792 21.6782L7.47918 20.5844L7.47919 20.5844C8.25353 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5344 19.0269 10.8229 18.7383 11.4001 18.1612L11.4001 18.1612L19.9213 9.63993L20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178Z"
                                                    stroke="currentColor" stroke-width="1.5" />
                                                <path opacity="0.5"
                                                    d="M14.36 4.07812C14.36 4.07812 14.4759 6.04774 16.2138 7.78564C17.9517 9.52354 19.9213 9.6394 19.9213 9.6394M4.19789 21.6777L2.32178 19.8015"
                                                    stroke="currentColor" stroke-width="1.5" />
                                            </svg>
                                        </a></li>
                                    <li><a wire:click="eliminar({{ $visitante->id }})" href="javascript:;" x-tooltip="Eliminar">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-danger">
                                                <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path
                                                    d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                                <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                                <path opacity="0.5"
                                                    d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                    stroke="currentColor" stroke-width="1.5" />
                                            </svg>
                                        </a></li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{-- Agregar la paginación aquí si es necesario --}}
            {{-- {{ $visitantes->links() }} --}}
        </div>
    </div>
</div>
