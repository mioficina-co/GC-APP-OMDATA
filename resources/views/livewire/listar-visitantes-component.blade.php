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
        <div class="w-full overflow-x-auto" wire:loading wire:target="cambiarEstadoVisitante">
            <div class="mt-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg shadow" role="status">
                Cambiando estado del visitante...
            </div>
        </div>
        @if (session('success'))
            <div wire:loading.remove class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow"
                role="status">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div wire:loading.remove class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow"
                role="status">
                {{ session('error') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="border-b px-4 py-3">#</th>
                        <th class="border-b px-4 py-3">Nombre y apellido</th>
                        <th class="border-b px-4 py-3">Documento</th>
                        <th class="border-b px-4 py-3">Teléfono</th>
                        <th class="border-b px-4 py-3">Email</th>
                        <th class="border-b px-4 py-3">EPS</th>
                        <th class="border-b px-4 py-3">ARL</th>
                        <th class="border-b px-4 py-3">Registrar salida</th>
                        <th class="border-b px-4 py-3">Fecha y hora de Entrada</th>
                        <th class="border-b px-4 py-3">Fecha y hora de Salida</th>
                        <th class="border-b px-4 py-3">Fecha de Creación</th>
                        <th class="border-b px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($visitantes as $index => $visitante)

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                            {{-- <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $visitante->nombre }}
                                @foreach ($visitante->visitas as $VisitasItem)
                                    <input type="image"
                                        src="{{ URL('storage/app/public/fotos/' . $VisitasItem->foto) }}"
                                        alt="">
                                @endforeach
                            </td> --}}
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->nombre }} <span>{{ $visitante->apellido }} </span> </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->numero_documento }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->telefono }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->eps->nombre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->arl->nombre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <div class="mb-5">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <button type="button" class="btn btn-info btn-sm" wire:click="registrarSalida({{ $visitante->id }})">
                                            Registro salida
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-600">
                                @foreach ($visitante->visitas as $visitaItem)
                                {{ $visitaItem->fecha_inicio }}
                                @endforeach

                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @foreach ($visitante->visitas as $visitaItem)
                                {{ $visitaItem->fecha_fin }}
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $visitante->created_at }}</td>
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
                                    {{-- <li><a wire:click="eliminar({{ $visitante->id }})" href="javascript:;"
                                            x-tooltip="Eliminar">

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
                                        </a></li> --}}
                                    <!-- standard  -->
                                    <div x-data="modal">
                                        <li><a href="javascript:;" x-tooltip="Eliminar" @click="toggle">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-danger">
                                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path
                                                        d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                    <path opacity="0.5"
                                                        d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                </svg>
                                            </a></li>
                                        {{-- <button type="button" class="btn btn-primary"
                                            @click="toggle">Standard</button> --}}
                                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto"
                                            :class="open && '!block'">
                                            <div class="flex items-start justify-center min-h-screen px-4"
                                                @click.self="open = false">
                                                <div x-show="open" x-transition x-transition.duration.300
                                                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
                                                    <div
                                                        class="dark:text-white-dark/70 text-base font-medium text-[#1f2937] p-5">
                                                        <div
                                                            class="flex items-center justify-center w-16 h-16 rounded-full bg-[#f1f2f3] dark:bg-white/10 mx-auto">
                                                            <svg width="28" height="28" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                                                                    stroke="currentColor" stroke-width="1.5"></path>
                                                                <path opacity="0.5"
                                                                    d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="p-5">
                                                        <div class="text-white-dark text-center">
                                                            <p class="text-xl font-semibold text-red-500">¿Estás seguro
                                                                de eliminar este visitante?</p>
                                                            <p class="mt-3 text-gray-700">Una vez que elimines a este
                                                                visitante, no podrás deshacer esta acción. ¿Deseas
                                                                continuar?</p>
                                                        </div>
                                                        <div class="flex justify-end items-center mt-8">
                                                            <button type="button" class="btn btn-outline-danger"
                                                                @click="toggle">Cancelar</button>
                                                            <button type="button"
                                                                wire:click="eliminar({{ $visitante->id }})"
                                                                class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                                                @click="toggle">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <li>
                                        <div class="flex items-center space-x-1">
                                            <label x-tooltip="Activar/Desactivar" class="w-8 h-4 relative">
                                                <input type="checkbox"
                                                    wire:click="cambiarEstadoVisitante({{ $visitante->id }})"
                                                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                                    @checked($visitante->activo) />
                                                <span
                                                    class="bg-[#bd1616] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-2 before:h-2 before:rounded-full peer-checked:before:left-5 peer-checked:bg-success before:transition-all before:duration-300"></span>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{-- Agregar la paginación aquí si es necesario --}}
            {{ $visitantes->links() }}
        </div>
    </div>
</div>
