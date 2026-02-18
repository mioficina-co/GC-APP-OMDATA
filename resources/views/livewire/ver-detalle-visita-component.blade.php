<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex justify-center items-center px-4 min-h-screen" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="overflow-hidden p-0 my-8 w-full max-w-4xl border-0 shadow-lg panel">

                    {{-- Header con gradiente según estado --}}
                    @if ($visita)
                        <div
                            class="flex items-center justify-between p-5 text-white {{ $visita->fecha_fin ? 'bg-gradient-to-r from-success to-green-600' : 'bg-gradient-to-r from-info to-blue-600' }}">
                            <div>
                                <h5 class="text-lg font-bold">Detalle de Ingreso #{{ $visita->id }}</h5>
                                <p class="text-xs font-bold tracking-widest uppercase opacity-80">
                                    {{ $visita->fecha_fin ? 'Visita Finalizada' : 'Visita en Curso' }}
                                </p>
                            </div>
                            <button type="button" @click="open = false" class="transition-transform hover:rotate-90">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                                {{-- Columna 1: Biometría (Foto y Firma del momento) --}}
                                <div class="space-y-4">
                                    <div class="bg-gray-50 border-none shadow-none panel dark:bg-white/5">
                                        <label class="text-[10px] font-bold uppercase text-gray-400 mb-2 block">Foto del
                                            Ingreso</label>
                                        @php $foto = $visita->archivos->where('tipo', 'foto')->first(); @endphp
                                        <div
                                            class="overflow-hidden w-full bg-white rounded-lg border-2 border-white shadow-md aspect-square">
                                            @if ($foto)
                                                <img src="{{ asset('storage/' . $foto->ruta) }}"
                                                    class="object-cover w-full h-full">
                                            @else
                                                <div
                                                    class="flex justify-center items-center w-full h-full text-gray-300">
                                                    Sin foto</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 border-none shadow-none panel dark:bg-white/5">
                                        <label class="text-[10px] font-bold uppercase text-gray-400 mb-2 block">Firma
                                            Digital</label>
                                        @php $firma = $visita->archivos->where('tipo', 'firma')->first(); @endphp
                                        <div
                                            class="flex overflow-hidden justify-center items-center w-full h-24 bg-white rounded-lg border border-gray-300 border-dashed">
                                            @if ($firma)
                                                <img src="{{ asset('storage/' . $firma->ruta) }}" class="max-h-full">
                                            @else
                                                <span class="text-[10px] text-gray-400 italic">No capturada</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Columna 2 y 3: Información --}}
                                <div class="space-y-6 md:col-span-2">
                                    {{-- Sección Visitante --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-2 pb-1 border-b border-gray-100 dark:border-white/10">
                                            <h6 class="text-xs font-bold uppercase text-primary">Información del
                                                Visitante</h6>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Nombre</p>
                                            <p class="text-sm font-bold">{{ $visita->visitante->nombre }}
                                                {{ $visita->visitante->apellido }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Identificación</p>
                                            <p class="text-sm">{{ $visita->visitante->tiposDocumento->nombre }}:
                                                {{ $visita->visitante->numero_documento }}</p>
                                        </div>
                                    </div>

                                    {{-- Sección Destino --}}
                                    <div
                                        class="grid grid-cols-2 gap-4 p-4 rounded-xl border bg-primary/5 border-primary/10">
                                        <div class="col-span-2">
                                            <h6 class="text-xs font-bold uppercase text-primary">Anfitrión y Motivo</h6>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Persona Visitada</p>
                                            <p class="text-sm font-semibold">{{ $visita->empleados->nombre }}
                                                {{ $visita->empleados->apellido }}</p>
                                            <p
                                                class="text-[10px] bg-primary text-white px-2 py-0.5 rounded-full w-fit mt-1">
                                                {{ $visita->departamentos->nombre }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Motivo</p>
                                            <p class="text-sm">{{ $visita->razonvisita->nombre }}</p>
                                            @if ($visita->otra_razon_visita)
                                                <p class="text-[11px] italic text-gray-500">
                                                    "{{ $visita->otra_razon_visita }}"</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Tiempos y Pertenencias --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Tiempos</p>
                                            <p class="text-[11px] text-success"><b>Entrada:</b>
                                                {{ \Carbon\Carbon::parse($visita->fecha_inicio)->format('d/m/Y H:i:s') }}
                                            </p>
                                            <p class="text-[11px] text-danger"><b>Salida:</b>
                                                {{ $visita->fecha_fin ? \Carbon\Carbon::parse($visita->fecha_fin)->format('d/m/Y H:i:s') : 'Pendiente' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Elementos Registrados</p>
                                            <p class="text-[11px] italic">
                                                {{ $visita->pertenencias ?? 'Sin pertenencias registradas' }}</p>
                                        </div>
                                    </div>

                                    {{-- Pie de Auditoría (Habeas Data) --}}
                                    <div
                                        class="grid grid-cols-2 gap-2 pt-4 mt-4 border-t border-gray-100 dark:border-white/10">
                                        <div class="text-[9px] text-gray-400 uppercase">
                                            Registrado por: <span
                                                class="font-bold">{{ $visita->created_by ?? 'Sistema' }}</span>
                                        </div>
                                        <div class="text-[9px] text-gray-400 uppercase text-right">
                                            IP Registro: <span
                                                class="font-bold">{{ $visita->visitante->ip_aceptacion ?? 'N/A' }}</span>
                                        </div>
                                        <div class="text-[9px] text-gray-400 uppercase col-span-2">
                                            Aceptación Ley 1581: <span class="font-bold text-success">SÍ (Versión
                                                {{ $visita->visitante->politicaAceptada?->version ?? 'v1.0' }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-8">
                                <button type="button" class="px-10 btn btn-outline-danger" @click="open = false">Cerrar
                                    Detalle</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
