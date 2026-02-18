<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex min-h-screen items-center justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="panel my-8 w-full max-w-lg overflow-hidden border-0 p-0 shadow-lg">

                    <div class="flex items-center justify-between p-5 font-semibold text-lg bg-info text-white">
                        Confirmar Salida de Visitante
                        <button type="button" @click="open = false" class="text-white hover:opacity-70">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5">
                        <div class="text-center mb-6">
                            <div
                                class="w-20 h-20 bg-info/10 text-info rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 dark:text-white-dark">{{ $nombreVisitante }}</h4>
                            <p class="text-gray-500 mt-1">Entrada: {{ $fechaEntrada }}</p>
                        </div>

                        @if ($pertenencias)
                            <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-md mb-6">
                                <h5 class="text-yellow-800 font-bold text-sm mb-1 uppercase">Pertenencias registradas:
                                </h5>
                                <p class="text-yellow-700 text-sm italic">{{ $pertenencias }}</p>
                            </div>
                        @endif

                        <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                            ¿Desea marcar la salida del visitante en este momento? Esta acción registrará la fecha y
                            hora actual.
                        </p>

                        <div class="flex items-center justify-center gap-4">
                            <button type="button" class="btn btn-outline-danger w-1/2"
                                @click="open = false">Cancelar</button>
                            <button type="button" class="btn btn-info w-1/2" wire:click="confirmarSalida">
                                <span wire:loading wire:target="confirmarSalida"
                                    class="animate-spin inline-block mr-2 w-3 h-3 border-2 border-white border-t-transparent rounded-full"></span>
                                Confirmar Salida
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
