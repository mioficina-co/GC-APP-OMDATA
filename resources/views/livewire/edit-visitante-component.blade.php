<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex min-h-screen items-center justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="panel my-8 w-full max-w-4xl overflow-hidden border-0 p-0 shadow-lg">

                    <!-- Alertas de sesión -->
                    @if (session('success'))
                        <div wire:key="alert-success-info-visitante-{{ microtime() }}" x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.500ms
                            class="mb-4 p-4 bg-green-100 text-green-700 border border-green-200 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" @click="show = false" class="text-green-700 hover:text-green-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div wire:key="alert-info-info-visitante-{{ microtime() }}" x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.500ms
                            class="mb-4 p-4 bg-blue-100 text-blue-700 border border-blue-200 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('info') }}</span>
                            </div>
                            <button type="button" @click="show = false" class="text-blue-700 hover:text-blue-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div wire:key="alert-error-info-visitante-{{ microtime() }}" x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.500ms
                            class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" @click="show = false" class="text-red-700 hover:text-red-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="flex items-center justify-between p-5 font-semibold text-lg dark:text-white">
                        Editar Perfil de Visitante
                        <button type="button" @click="open = false" class="text-white-dark hover:text-dark">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5">
                        <form wire:submit.prevent="update">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Salud y Seguro -->
                                <div>
                                    <label>EPS</label>
                                    <select wire:model="visitanteForm.eps_id" class="form-select">
                                        <option value="">Seleccione una EPS</option>
                                        @foreach ($visitanteForm->eps as $e)
                                            <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label>ARL</label>
                                    <select wire:model="visitanteForm.arl_id" class="form-select">
                                        <option value="">Seleccione una ARL</option>
                                        @foreach ($visitanteForm->arl as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Contacto -->
                                <div>
                                    <label>Celular</label>
                                    <input type="text" wire:model="visitanteForm.telefono" class="form-input" />
                                </div>
                                <div>
                                    <label>Email</label>
                                    <input type="email" wire:model="visitanteForm.email" class="form-input" />
                                </div>

                                <!-- Emergencia -->
                                <div>
                                    <label>Contacto Emergencia</label>
                                    <input type="text" wire:model="visitanteForm.nombre_contacto_emergencia"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label>Teléfono Emergencia</label>
                                    <input type="text" wire:model="visitanteForm.numero_contacto_emergencia"
                                        class="form-input" />
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-end border-t pt-5">
                                <button type="button" class="btn btn-outline-danger"
                                    @click="open = false">Cancelar</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">
                                    <span wire:loading
                                        class="animate-spin inline-block mr-2 w-3 h-3 border-2 border-white border-t-transparent rounded-full"></span>
                                    Actualizar Datos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
