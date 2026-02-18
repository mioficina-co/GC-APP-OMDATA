<div>
    <div x-data="{ open: @entangle('showModal') }">
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="{ '!block': open }">
            <div class="flex min-h-screen items-center justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition.duration.300
                    class="panel my-8 w-full max-w-lg overflow-hidden border-0 p-0 shadow-lg">

                    <div class="flex items-center justify-between p-5 font-semibold text-lg dark:text-white">
                        Editar Empleado
                        <button type="button" @click="open = false" class="text-white-dark hover:text-dark">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="w-6 h-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="p-5">
                        <form wire:submit.prevent="update">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>Nombre</label>
                                    <input type="text" wire:model="nombre" class="form-input" />
                                    @error('nombre')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label>Apellido</label>
                                    <input type="text" wire:model="apellido" class="form-input" />
                                    @error('apellido')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label>Documento</label>
                                    <input type="text" wire:model="documento" class="form-input" />
                                    @error('documento')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label>Departamento</label>
                                    <select wire:model="departamento_id" class="form-select">
                                        <option value="">Seleccione...</option>
                                        @foreach ($departamentos as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('departamento_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-end">
                                <button type="button" class="btn btn-outline-danger"
                                    @click="open = false">Cancelar</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">
                                    <span wire:loading wire:target="update"
                                        class="animate-spin inline-block mr-2 w-3 h-3 border-2 border-white border-t-transparent rounded-full"></span>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
