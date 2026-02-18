<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Configuración</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Gestión de Privacidad (Ley 1581)</span>
        </li>
    </ul>

    <div class="pt-5 grid grid-cols-1 lg:grid-cols-1 gap-6 justify-center">
        <div class="panel col-span-1 lg:col-span-1">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-semibold text-lg dark:text-white-light">Políticas de Privacidad</h5>

                <div class="flex items-center">
                    <!-- Mensajes de Estado -->
                    @if (session()->has('error'))
                        <div wire:loading.remove
                            class="p-2 bg-red-100 border border-red-400 text-red-700 rounded shadow-sm text-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div wire:loading.remove
                            class="p-2 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Indicador de carga -->
                    <div wire:loading
                        class="p-2 bg-blue-100 border border-blue-400 text-blue-700 rounded shadow-sm text-sm">
                        Procesando actualización...
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <form class="space-y-5" wire:submit.prevent="registroPolitica">
                    <div class="mb-6">
                        <h6 class="font-semibold text-md dark:text-white-light mb-4">Actualizar Texto de Consentimiento
                            Habitual</h6>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Input Versión -->
                            <div class="lg:col-span-1">
                                <label for="version">Versión del Documento</label>
                                <input type="text" id="version" placeholder="Ejemplo: v1.2 - Febrero 2024"
                                    class="form-input w-full" wire:model="version" />
                                @error('version')
                                    <p class="text-red-600 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Textarea Contenido -->
                            <div class="lg:col-span-1">
                                <label for="contenido">Contenido Legal (Tratamiento de Datos Personales)</label>
                                <textarea id="contenido" rows="8"
                                    placeholder="Escriba aquí el texto que aparecerá en el formulario de registro de visitantes..."
                                    class="form-textarea w-full" wire:model="contenido"></textarea>
                                @error('contenido')
                                    <p class="text-red-600 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Checkbox Activa -->
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="activa" class="form-checkbox" wire:model="activa" />
                                <label for="activa" class="text-white-dark">Establecer como política vigente para
                                    nuevos registros</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="mt-6 flex justify-end w-full">
                        <button type="submit" class="btn btn-primary px-10">Publicar Nueva Versión</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla Histórica (Opcional, pero recomendada para ver versiones) -->
        <div class="panel mt-6">
            <h5 class="font-semibold text-lg mb-4 text-white-dark">Historial de versiones publicadas</h5>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Versión</th>
                            <th>Fecha Publicación</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($politicas as $p)
                            <tr>
                                <td>{{ $p->version }}</td>
                                <td>{{ $p->fecha_publicacion }}</td>
                                <td>
                                    @if ($p->activa)
                                        <span class="badge badge-outline-success">Vigente (Activa)</span>
                                    @else
                                        <span class="badge badge-outline-danger">Archivada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
