<div>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Registro de empleados</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>{{ request()->path() }} </span>
            </li>
        </ul>
        <div class="grid grid-cols-1 gap-6 justify-center pt-5 lg:grid-cols-1">
            <div class="col-span-1 panel lg:col-span-1">
                <div class="flex justify-between items-center mb-5">
                    <h5 class="text-lg font-semibold dark:text-white-light">Datos basicos registro de empleados</h5>
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
                                        <span
                                            class="text-xs font-bold tracking-wider uppercase">{{ session($msg) }}</span>
                                    </div>
                                    <button @click="show = false" class="hover:opacity-70"><svg width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M18 6L6 18M6 6l12 12" />
                                        </svg></button>
                                </div>
                            @endif
                        @endforeach
                        <!-- Indicador de carga -->
                        <div wire:loading
                            class="p-4 mt-4 text-blue-700 bg-blue-100 rounded-lg border border-blue-400 shadow"
                            role="status">
                            <p class="font-medium">Procesando, por favor espere...</p>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <form class="space-y-5" wire:submit.prevent="registroEmpleado">
                        <div class="mb-6">
                            <h6 class="mb-4 text-lg font-semibold dark:text-white-light">Registro de empleados</h6>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                                <div class="lg:col-span-1 sm:col-span-2">
                                    <input type="text" placeholder="Nombres completos" class="w-full form-input"
                                        wire:model="nombre" />
                                    <div class="mt-2 text-sm text-red-600">
                                        @error('nombre')
                                            <p class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="lg:col-span-1 sm:col-span-2">
                                    <input type="text" placeholder="Apellidos" class="w-full form-input"
                                        wire:model="apellido" />
                                    <div class="mt-2 text-sm text-red-600">
                                        @error('apellido')
                                            <p class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="lg:col-span-1 sm:col-span-2">
                                    <input type="text" placeholder="Documento de identificación"
                                        class="w-full form-input" wire:model="documento" />
                                    <div class="mt-2 text-sm text-red-600">
                                        @error('documento')
                                            <p class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="lg:col-span-1 sm:col-span-2">
                                    <select wire:model="departamento_id" class="form-select text-white-dark">
                                        <option value="">Seleccione un departamento</option>
                                        @foreach ($departamentos as $departamentoItem)
                                            <option value="{{ $departamentoItem->id }}">
                                                {{ $departamentoItem->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2 text-sm text-red-600">
                                        @error('departamento_id')
                                            <p class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón de envío -->
                        <div class="grid justify-center mt-6 w-full sm:grid-cols-1 lg:grid-cols-2">
                            <button type="submit" class="mx-1 my-1 btn btn-primary">Registrar empleado</button>

                            <label for="file-upload"
                                class="p-3 mx-1 my-1 text-center text-gray-800 bg-gray-200 rounded-lg shadow-md cursor-pointer tn btn-inline btn-default hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                                Carga masiva
                            </label>

                            <!-- Input de subida (oculto) -->
                            <input id="file-upload" type="file" class="hidden" accept=".csv,.txt"
                                wire:model="archivoEmpleados" />

                            <!-- Mensaje de error para el archivo -->
                            <div class="mt-2 text-sm text-red-600">
                                @error('archivoEmpleados')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
