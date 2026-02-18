<div>
    <div>
        <div class="panel">
            {{-- Header y Filtros --}}
            <div class="flex flex-wrap gap-4 justify-between items-center mb-5">
                <h2 class="flex gap-3 items-center text-xl font-bold dark:text-white-light">
                    <div class="p-2 rounded-lg bg-warning/10 text-warning">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Historial de Visitas
                </h2>

                <div class="grid grid-cols-1 gap-3 w-full sm:grid-cols-2 md:grid-cols-4 lg:w-auto">
                    {{-- Fecha Desde --}}
                    <input type="date" wire:model.live="dateFrom" class="text-xs form-input" />

                    {{-- Fecha Hasta --}}
                    <input type="date" wire:model.live="dateTo" class="text-xs form-input" />

                    {{-- Estado --}}
                    <select wire:model.live="status" class="text-xs form-select">
                        <option value="all">Todos los estados</option>
                        <option value="ongoing">En curso</option>
                        <option value="finished">Finalizadas</option>
                    </select>

                    {{-- Buscador --}}
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Visitante o Empleado..." class="form-input ltr:pr-11 rtl:pl-11" />
                        <div class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 text-[#506690]">
                            <span wire:loading wire:target="search, status, dateFrom, dateTo"
                                class="block w-4 h-4 rounded-full border-2 animate-spin border-primary border-l-transparent"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de Visitas --}}
            <div class="table-responsive">
                <table class="table-hover table-striped">
                    <thead>
                        <tr class="dark:text-white-light">
                            <th>Visitante</th>
                            <th>Anfitrión (Empleado)</th>
                            <th>Motivo</th>
                            <th class="text-center">Estado</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Duración</th>
                            <th class="text-center">Evidencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visitas as $visita)
                            <tr>
                                {{-- Visitante con Foto --}}
                                <td>
                                    <div class="flex gap-3 items-center">
                                        @php $foto = $visita->archivos->where('tipo', 'foto')->first(); @endphp
                                        <img src="{{ $foto ? asset('storage/' . $foto->ruta) : 'https://ui-avatars.com/api/?name=' . urlencode($visita->visitante->nombre) }}"
                                            class="object-cover w-10 h-10 rounded-full border border-gray-200">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">{{ $visita->visitante->nombre }}
                                                {{ $visita->visitante->apellido }}</span>
                                            <span
                                                class="text-[10px] text-gray-400">{{ $visita->visitante->numero_documento }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Empleado y Depto --}}
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $visita->empleados->nombre }}
                                            {{ $visita->empleados->apellido }}</span>
                                        <span
                                            class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded w-fit">{{ $visita->departamentos->nombre }}</span>
                                    </div>
                                </td>

                                {{-- Motivo --}}
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold">{{ $visita->razonvisita->nombre }}</span>
                                        @if ($visita->otra_razon_visita)
                                            <span
                                                class="text-[10px] text-gray-400 italic">"{{ $visita->otra_razon_visita }}"</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Estado Badge --}}
                                <td class="text-center">
                                    @if ($visita->fecha_fin)
                                        <span
                                            class="badge badge-outline-success text-[9px] uppercase font-extrabold">Finalizada</span>
                                    @else
                                        <span
                                            class="flex items-center justify-center gap-1 text-info animate-pulse text-[9px] font-black uppercase">
                                            <span class="w-2 h-2 rounded-full bg-info"></span> En curso
                                        </span>
                                    @endif
                                </td>

                                {{-- Tiempos --}}
                                <td class="text-xs">
                                    {{ \Carbon\Carbon::parse($visita->fecha_inicio)->format('d/m/Y H:i') }}</td>
                                <td class="text-xs">
                                    {{ $visita->fecha_fin ? \Carbon\Carbon::parse($visita->fecha_fin)->format('d/m/Y H:i') : '---' }}
                                </td>

                                {{-- Duración Calculada --}}
                                <td class="font-mono text-xs">
                                    @if ($visita->fecha_fin)
                                        @php
                                            $entrada = \Carbon\Carbon::parse($visita->fecha_inicio);
                                            $salida = \Carbon\Carbon::parse($visita->fecha_fin);
                                            echo $entrada->diffForHumans($salida, true, false, 2);
                                        @endphp
                                    @else
                                        <span class="text-gray-300">...</span>
                                    @endif
                                </td>

                                {{-- Evidencia (Miniaturas) --}}
                                <td class="text-center">
                                    <div class="flex gap-2 justify-center items-center">
                                        {{-- BOTÓN EDITAR --}}
                                        <button type="button" wire:click="editarVisita({{ $visita->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="editarVisita({{ $visita->id }})"
                                            class="inline-flex relative justify-center items-center w-8 h-8 transition text-warning hover:scale-110"
                                            x-tooltip="Corregir Registro">

                                            {{-- Icono original: se quita al cargar --}}
                                            <span wire:loading.remove wire:target="editarVisita({{ $visita->id }})">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path
                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </span>

                                            {{-- Spinner: aparece al cargar (color warning para combinar) --}}
                                            <span wire:loading wire:target="editarVisita({{ $visita->id }})"
                                                class="w-4 h-4 rounded-full border-2 animate-spin border-warning border-l-transparent">
                                            </span>
                                        </button>

                                        {{-- BOTÓN DETALLE --}}
                                        <button type="button" wire:click="verDetalleVisita({{ $visita->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="verDetalleVisita({{ $visita->id }})"
                                            class="inline-flex relative justify-center items-center p-1 w-8 h-8 btn btn-xs btn-outline-primary">

                                            {{-- Icono original --}}
                                            <span wire:loading.remove
                                                wire:target="verDetalleVisita({{ $visita->id }})">
                                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </span>

                                            {{-- Spinner --}}
                                            <span wire:loading wire:target="verDetalleVisita({{ $visita->id }})"
                                                class="w-4 h-4 rounded-full border-2 animate-spin border-primary border-l-transparent">
                                            </span>
                                        </button>

                                        {{-- REGISTRO DE SALIDA --}}
                                        @if ($visita->fecha_fin)
                                            <span
                                                class="badge badge-outline-success font-bold text-[10px] uppercase px-3">Salida
                                                Registrada</span>
                                        @else
                                            <button type="button"
                                                class="flex gap-2 items-center shadow-none btn btn-info btn-sm"
                                                wire:click="registrarSalida({{ $visita->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="registrarSalida({{ $visita->id }})">

                                                <span wire:loading.remove
                                                    wire:target="registrarSalida({{ $visita->id }})">Registrar
                                                    salida</span>

                                                <span wire:loading wire:target="registrarSalida({{ $visita->id }})"
                                                    class="w-4 h-4 rounded-full border-2 border-white animate-spin border-l-transparent"></span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 text-center text-gray-400">No se encontraron visitas
                                    en
                                    el rango seleccionado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $visitas->links() }}
            </div>
        </div>
    </div>

    <livewire:registro-salida-component :key="'registro-salida-' . time()" />
    <livewire:edit-visita-component :key="'edit-visita-' . time()" />
    <livewire:ver-detalle-visita-component :key="'edit-detalle-' . time()" />
</div>
