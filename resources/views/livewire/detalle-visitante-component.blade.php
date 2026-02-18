<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex min-h-screen items-center justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="panel my-8 w-full max-w-4xl overflow-hidden border-0 p-0 shadow-lg">

                    {{-- Header del Modal --}}
                    <div
                        class="flex items-center justify-between p-5 bg-gradient-to-r from-primary to-blue-600 text-white">
                        <h5 class="text-lg font-bold">Ficha Completa del Visitante</h5>
                        <button type="button" @click="open = false"
                            class="hover:rotate-90 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    @if ($visitante)
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-8">
                                {{-- Columna Izquierda: Foto y Estado --}}
                                <div class="w-full md:w-1/3 flex flex-col items-center">
                                    <div
                                        class="w-40 h-40 rounded-xl overflow-hidden border-4 border-white shadow-xl mb-4">
                                        @if ($visitante->ultimaFoto)
                                            <img src="{{ asset('storage/' . $visitante->ultimaFoto->ruta) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($visitante->nombre) }}&size=200"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <span
                                        class="badge {{ $visitante->activo ? 'badge-outline-success' : 'badge-outline-danger' }} rounded-full px-6">
                                        {{ $visitante->activo ? 'Perfil Activo' : 'Perfil Restringido' }}
                                    </span>
                                    <div class="mt-4 text-center">
                                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">RH / Grupo
                                            Sanguíneo</p>
                                        <p class="text-2xl font-black text-danger">{{ $visitante->rh }}</p>
                                    </div>
                                </div>

                                {{-- Columna Derecha: Información Detallada --}}
                                <div class="w-full md:w-2/3 space-y-6">

                                    {{-- Sección 1: Datos Personales --}}
                                    <div>
                                        <h6
                                            class="text-primary font-bold border-b border-primary/20 pb-1 mb-3 uppercase text-xs tracking-tighter">
                                            Información de Identidad</h6>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">Nombre
                                                    Completo</label>
                                                <p class="font-semibold text-gray-800 dark:text-white-dark">
                                                    {{ $visitante->nombre }} {{ $visitante->apellido }}</p>
                                            </div>
                                            <div>
                                                <label
                                                    class="text-gray-400 text-[10px] uppercase block">{{ $visitante->tiposDocumento->nombre }}</label>
                                                <p class="font-semibold text-gray-800 dark:text-white-dark">
                                                    {{ $visitante->numero_documento }}</p>
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">Correo
                                                    Electrónico</label>
                                                <p class="text-sm">{{ $visitante->email ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">Teléfono /
                                                    Celular</label>
                                                <p class="text-sm">{{ $visitante->telefono ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sección 2: Seguridad y Salud --}}
                                    <div
                                        class="bg-gray-50 dark:bg-white/5 p-4 rounded-lg border border-gray-100 dark:border-white/10">
                                        <h6 class="text-info font-bold mb-3 uppercase text-xs">Seguridad Social y
                                            Emergencia</h6>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">EPS</label>
                                                <p class="text-sm font-bold text-blue-600">
                                                    {{ $visitante->eps->nombre }}</p>
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">ARL</label>
                                                <p class="text-sm font-bold text-orange-600">
                                                    {{ $visitante->arl->nombre }}</p>
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">Contacto
                                                    Emergencia</label>
                                                <p class="text-sm">
                                                    {{ $visitante->nombre_contacto_emergencia ?? 'No registrado' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-gray-400 text-[10px] uppercase block">Tel.
                                                    Emergencia</label>
                                                <p class="text-sm">
                                                    {{ $visitante->numero_contacto_emergencia ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sección 3: Última Visita --}}
                                    @if ($visitante->ultimaVisita)
                                        <div>
                                            <h6
                                                class="text-warning font-bold border-b border-warning/20 pb-1 mb-3 uppercase text-xs">
                                                Detalle del Último Ingreso</h6>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="col-span-2">
                                                    <label class="text-gray-400 text-[10px] uppercase block">Motivo de
                                                        Visita</label>
                                                    <p class="text-sm">
                                                        <span
                                                            class="font-bold">{{ $visitante->ultimaVisita->razonvisita->nombre }}</span>
                                                        @if ($visitante->ultimaVisita->otra_razon_visita)
                                                            - {{ $visitante->ultimaVisita->otra_razon_visita }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-gray-400 text-[10px] uppercase block">Visitó
                                                        a</label>
                                                    <p class="text-sm">
                                                        {{ $visitante->ultimaVisita->empleados->nombre }}
                                                        ({{ $visitante->ultimaVisita->departamentos->nombre }})</p>
                                                </div>
                                                <div>
                                                    <label
                                                        class="text-gray-400 text-[10px] uppercase block">Pertenencias
                                                        declaradas</label>
                                                    <p class="text-xs italic text-gray-500">
                                                        {{ $visitante->ultimaVisita->pertenencias ?? 'Ninguna' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Sección Legal --}}
                                    <div
                                        class="pt-4 border-t border-gray-100 flex justify-between items-center text-[10px] text-gray-400">
                                        <span>Aceptó política: {{ $visitante->fecha_aceptacion_politica }}</span>
                                        <span>Versión: {{ $visitante->politicaAceptada?->version ?? 'v1.0' }}</span>
                                        <span>IP: {{ $visitante->ip_aceptacion }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="button" class="btn btn-outline-primary px-10"
                                    @click="open = false">Cerrar Ficha</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
