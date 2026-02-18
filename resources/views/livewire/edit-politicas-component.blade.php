<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex min-h-screen items-center justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="panel my-8 w-full max-w-4xl overflow-hidden border-0 p-0 shadow-lg">

                    <div class="flex items-center justify-between p-5 font-semibold text-lg dark:text-white">
                        {{ $politicaId ? 'Editar Política' : 'Nueva Política de Privacidad' }}
                        <button type="button" @click="open = false" class="text-white-dark hover:text-dark">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M18 6L6 18M6 6l12 12" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5">
                        <form wire:submit.prevent="save">
                            <div class="space-y-4">
                                <div>
                                    <label class="font-bold">Versión / Identificador</label>
                                    <input type="text" wire:model="version" class="form-input"
                                        placeholder="Ej: v1.1 - Marzo 2024" />
                                    @error('version')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="font-bold">Contenido Legal Completo</label>
                                    <textarea wire:model="contenido" class="form-textarea" rows="12" placeholder="Pegue aquí el texto legal..."></textarea>
                                    @error('contenido')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if (!$politicaId)
                                    <div class="flex items-center gap-2 mt-2">
                                        <input type="checkbox" wire:model="activa" id="checkActiva"
                                            class="form-checkbox" />
                                        <label for="checkActiva">Activar automáticamente al guardar</label>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-8 flex items-center justify-end border-t pt-5">
                                <button type="button" class="btn btn-outline-danger"
                                    @click="open = false">Cancelar</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">
                                    <span wire:loading
                                        class="animate-spin inline-block mr-2 w-3 h-3 border-2 border-white border-t-transparent rounded-full"></span>
                                    {{ $politicaId ? 'Actualizar Texto' : 'Publicar Política' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
