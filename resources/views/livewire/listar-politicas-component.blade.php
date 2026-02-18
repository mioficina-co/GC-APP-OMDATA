<div>
    <div class="panel">
        {{-- Cabecera Principal: Título + Buscador + Botón Nueva --}}
        <div class="flex flex-wrap gap-4 justify-between items-center mb-5">
            <h2 class="flex gap-3 items-center text-xl font-bold dark:text-white-light">
                <div class="p-2 rounded-lg bg-secondary/10 text-secondary">
                    {{-- Icono de documento legal --}}
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                Gestión de Políticas (Ley 1581)
            </h2>

            <div class="flex flex-col gap-3 w-full sm:flex-row sm:w-auto">
                {{-- BARRA DE BÚSQUEDA --}}
                <div class="relative w-full sm:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Buscar versión o contenido..." class="h-10 form-input ltr:pr-11 rtl:pl-11 peer" />

                    <div
                        class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 text-[#506690] peer-focus:text-primary transition-colors">
                        {{-- Icono Lupa (Se oculta al cargar) --}}
                        <svg wire:loading.remove wire:target="search" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        {{-- Spinner de búsqueda --}}
                        <span wire:loading wire:target="search"
                            class="block w-5 h-5 rounded-full border-2 animate-spin border-primary border-l-transparent"></span>
                    </div>
                </div>

                {{-- Botón Nueva Versión --}}
                <button type="button" class="gap-2 h-10 btn btn-primary" wire:click="openModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Nueva Versión
                </button>
            </div>
        </div>

        {{-- Alertas de Sesión Dinámicas con Autocierre --}}
        <div class="mb-5 space-y-3">
            @foreach (['success', 'error', 'info'] as $msg)
                @if (session()->has($msg))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                        wire:key="alert-politica-{{ $msg }}-{{ microtime() }}"
                        class="p-3 rounded-lg flex items-center justify-between {{ $msg == 'success' ? 'bg-success/10 text-success border border-success/20' : ($msg == 'error' ? 'bg-danger/10 text-danger border border-danger/20' : 'bg-info/10 text-info border border-info/20') }}">
                        <div class="flex gap-2 items-center">
                            @if ($msg == 'success')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                            <span class="text-xs font-bold tracking-wider uppercase">{{ session($msg) }}</span>
                        </div>
                        <button @click="show = false" class="hover:opacity-70"><svg width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 6L6 18M6 6l12 12" />
                            </svg></button>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Tabla de Políticas --}}
        <div class="table-responsive">
            <table class="table-hover table-striped">
                <thead>
                    <tr class="dark:text-white-light">
                        <th class="w-1/4">Identificador / Versión</th>
                        <th class="w-1/4">Fecha de Publicación</th>
                        <th class="w-1/4 text-center">Estado (Vigente)</th>
                        <th class="w-1/4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($politicas as $item)
                        <tr class="border-b" wire:key="row-politica-{{ $item->id }}">
                            <td class="font-bold text-primary">{{ $item->version }}</td>
                            <td class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($item->fecha_publicacion)->format('d/m/Y H:i') }}</td>

                            {{-- Radio Switch Estilizado --}}
                            <td class="text-center">
                                <div class="flex justify-center items-center">
                                    <label class="inline-block relative w-12 h-6">
                                        <input type="radio" name="politica_vigente" value="{{ $item->id }}"
                                            wire:model.live="politicaActivaId"
                                            class="absolute z-10 w-full h-full opacity-0 cursor-pointer custom_switch peer"
                                            wire:loading.attr="disabled" />

                                        <span
                                            class="bg-danger block h-full rounded-full before:absolute before:left-1 before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-success transition-all duration-300 relative
                                            wire:loading.class="before:opacity-0"
                                            wire:target="politicaActivaId({{ $item->id }})">

                                            {{-- Spinner interno --}}
                                            <span wire:loading wire:target="politicaActivaId({{ $item->id }})"
                                                class="flex absolute inset-0 justify-center items-center">
                                                <span
                                                    class="w-3 h-3 rounded-full border-2 border-white animate-spin border-t-transparent"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </td>

                            {{-- Botones de Acción --}}
                            <td class="text-center">
                                <div class="flex gap-3 justify-center">
                                    <button wire:click="openModal({{ $item->id }})"
                                        class="p-1 transition text-success hover:scale-110"
                                        x-tooltip="Editar Versión">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path>
                                            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                            </path>
                                        </svg>
                                    </button>

                                    @if ($politicaActivaId != $item->id)
                                        <button
                                            onclick="confirm('¿Está seguro de archivar esta versión legal? No podrá ser eliminada si tiene registros asociados.') || event.stopImmediatePropagation()"
                                            wire:click="eliminar({{ $item->id }})"
                                            class="p-1 transition text-danger hover:scale-110"
                                            x-tooltip="Archivar Política">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M19 6L5 20M5 6l14 14" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="mb-3 w-12 h-12 opacity-20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>No se encontraron políticas que coincidan con "{{ $search }}"</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación estilizada --}}
        <div class="flex flex-wrap gap-4 justify-between items-center mt-6">
            <div class="text-xs font-bold tracking-widest text-gray-500 uppercase">
                Versiones registradas: {{ $politicas->total() }}
            </div>
            {{ $politicas->links() }}
        </div>
    </div>

    {{-- Componente Modal --}}
    <livewire:edit-politicas-component :key="'modal-pol-' . time()" />
</div>
