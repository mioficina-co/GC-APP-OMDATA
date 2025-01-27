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
        <div class="pt-5 grid grid-cols-1 lg:grid-cols-1 gap-6 justify-center">
            <!-- Basic -->
            <div class="panel col-span-1 lg:col-span-1 mx-60">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Datos basicos registro de empleados</h5>
                    <a class="font-semibold hover:text-gray-400 dark:text-gray-400 dark:hover:text-gray-600"
                        href="javascript:;" @click="toggleCode('code12')">
                        <span class="flex items-center">


                        </span>
                    </a>
                    <!-- Mensaje de error -->
                    @if (session()->has('error'))
                        <div wire:loading.remove
                            class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow"
                            role="alert">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Mensaje de éxito -->
                    @if (session()->has('success'))
                        <div wire:loading.remove
                            class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow"
                            role="status">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Mensaje de información -->
                    @if (session()->has('info'))
                        <div wire:loading.remove
                            class="mt-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg shadow"
                            role="status">
                            <p class="font-medium">{{ session('info') }}</p>
                        </div>
                    @endif

                    <!-- Indicador de carga -->
                    <div wire:loading wire:target="registroEmpleado, cargaMasiva, updatedarchivoEmpleados"
                        class="mt-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg shadow"
                        role="status">
                        <p class="font-medium">Procesando, por favor espere...</p>
                    </div>


                </div>
                <div class="mb-5">
                    <form class="space-y-5" wire:submit.prevent="registroEmpleado">
                        <div class="mb-6">
                            <h6 class="font-semibold text-lg dark:text-white-light mb-4">Registro de empleados</h6>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                                <div class="lg:col-span-1 sm:col-span-2">
                                    <input type="text" placeholder="Nombres completos" class="form-input w-full"
                                        wire:model="nombre" />
                                    <div class="text-sm text-red-600 mt-2">
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
                                    <input type="text" placeholder="Apellidos" class="form-input w-full"
                                        wire:model="apellido" />
                                    <div class="text-sm text-red-600 mt-2">
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
                                        class="form-input w-full" wire:model="documento" />
                                    <div class="text-sm text-red-600 mt-2">
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
                                            <option value="{{ $departamentoItem->id }}">{{ $departamentoItem->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-sm text-red-600 mt-2">
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
                        <div class="mt-6 grid sm:grid-cols-1 lg:grid-cols-2 justify-center w-full">
                            <button type="submit" class="btn btn-primary mx-1 my-1">Registrar empleado</button>

                            <label for="file-upload"
                                class="cursor-pointer text-center tn btn-inline btn-default mx-1 my-1 p-3 bg-gray-200 text-gray-800 rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                                Carga masiva
                            </label>

                            <!-- Input de subida (oculto) -->
                            <input id="file-upload" type="file" class="hidden" accept=".csv,.txt"
                                wire:model="archivoEmpleados" />

                            <!-- Mensaje de error para el archivo -->
                            <div class="text-sm text-red-600 mt-2">
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
