<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex justify-center items-center px-4 min-h-screen" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="overflow-hidden p-0 my-8 w-full max-w-2xl border-0 shadow-lg panel">

                    {{-- Header --}}
                    <div class="flex justify-between items-center p-5 text-lg font-bold text-white bg-warning">
                        <div class="flex gap-2 items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Corregir Registro de Visita
                        </div>
                        <button type="button" @click="open = false" class="hover:opacity-70"><svg class="w-6 h-6"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"></path>
                            </svg></button>
                    </div>

                    <div class="p-6">
                        <form wire:submit.prevent="update" class="space-y-5">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                {{-- Empleado Anfitrión --}}
                                <div class="col-span-1 md:col-span-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Funcionario
                                        Anfitrión</label>
                                    <select wire:model="empleado_id" class="form-select">
                                        <option value="">Seleccione el funcionario...</option>
                                        @foreach ($empleados as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->nombre }} {{ $emp->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('empleado_id')
                                        <span class="text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Motivo --}}
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Motivo de Visita</label>
                                    <select wire:model.live="razon_id" class="form-select">
                                        @foreach ($razones as $razon)
                                            <option value="{{ $razon->id }}">{{ $razon->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Fecha de Salida (Ajuste manual) --}}
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Fecha/Hora Salida
                                        (Manual)</label>
                                    <input type="datetime-local" wire:model="fecha_fin" class="form-input" />
                                    <p class="text-[9px] text-info mt-1 italic">* Use esto si el visitante olvidó
                                        registrar su salida.</p>
                                </div>

                                {{-- Otra Razón (Condicional) --}}
                                @if ($esOtro)
                                    <div class="col-span-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Especifique el
                                            motivo</label>
                                        <input type="text" wire:model="otra_razon_visita" class="form-input"
                                            placeholder="¿Cuál es el motivo?" />
                                    </div>
                                @endif

                                {{-- Pertenencias --}}
                                <div class="col-span-2">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Pertenencias / Elementos
                                        Registrados</label>
                                    <textarea wire:model="pertenencias" rows="3" class="form-textarea" placeholder="Ej: Portátil HP Serial XYZ..."></textarea>
                                </div>
                            </div>

                            <div class="flex gap-3 justify-end items-center pt-5 mt-8 border-t">
                                <button type="button" class="btn btn-outline-danger"
                                    @click="open = false">Cancelar</button>
                                <button type="submit" class="px-10 btn btn-warning">
                                    <span wire:loading wire:target="update"
                                        class="inline-block mr-2 w-4 h-4 rounded-full border-2 border-white animate-spin border-l-transparent"></span>
                                    Guardar Correcciones
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
