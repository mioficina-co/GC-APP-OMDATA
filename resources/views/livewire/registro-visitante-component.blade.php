<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="panel lg:col-span-2">
        @if (!$empleados->count())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow" role="status">
                No hay empleados registrados, en el sistema
            </div>
        @endif
        <div class="mb-5">
            <form x-data="formularioVisitante()" wire:submit.prevent="submitSignature" x-init="init()"
                @submit.prevent="scrollToFirstError()">
                {{-- seccion numero 1 --}}
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Datos Personales</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="col-span-1">
                            <select wire:model.change="empleado" class="form-select text-white-dark">
                                <option value="">Seleccione un empleado</option>
                                <!-- Valor vacío para opción por defecto -->
                                @foreach ($empleados as $empleadosItem)
                                    <option wire:key="empleado-{{ $empleadosItem->id }}"
                                        value="{{ $empleadosItem->id }}">
                                        {{ $empleadosItem->nombre }} - {{ $empleadosItem->apellido }}</option>
                                    <!-- Usando el ID como valor -->
                                @endforeach
                            </select>
                            <!-- Mensaje de error si no se selecciona ningun empleado -->
                            <div class="text-sm text-red-600 mt-2">
                                @error('empleado')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <select wire:model="departamento" class="form-select text-white-dark" disabled>
                                <option value="">Seleccione un departamento</option>
                                @foreach ($departamentos as $departamentoItem)
                                    <option value="{{ $departamentoItem->id }}">
                                        {{ $departamentoItem->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select wire:model="razonvisita" class="form-select text-white-dark">
                                <option value="">Seleccione razón de la visita</option>
                                @foreach ($razones as $razonesItem)
                                    <option wire:key="$razonesItem->id" value="{{ $razonesItem->id }}">
                                        {{ $razonesItem->nombre }}</option>
                                    <!-- Usando el ID como valor -->
                                @endforeach
                            </select>
                            <div class="text-sm text-red-600 mt-2">
                                @error('razonvisita')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-1">
                            <input type="text" placeholder="Nombre" class="form-input w-full" wire:model="nombre" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('nombre')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-1">
                            <input type="text" placeholder="Apellido" class="form-input w-full"
                                wire:model="apellido" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('apellido')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <select wire:model="tipodocumento" name="tipodocumento" class="form-select text-white-dark">
                                <option value="">Seleccione un tipo de documento</option>
                                @foreach ($tipoDocumento as $tipoDocumentoItem)
                                    <option wire:key="$tipoDocumentoItem->id" value="{{ $tipoDocumentoItem->id }}">
                                        {{ $tipoDocumentoItem->nombre }}
                                    </option>
                                    <!-- Usando el ID como valor -->
                                @endforeach
                            </select>
                            <div class="text-sm text-red-600 mt-2">
                                @error('tipodocumento')
                                    <p class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-1">
                            <input type="text" placeholder="Numero de documento de identidad"
                                class="form-input w-full" wire:model="numerodocumento" pattern="^\d{6,10}$"
                                title="El número de documento debe ser un número de entre 6 y 10 dígitos" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('numerodocumento')
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

                        <div class="col-span-1">
                            <input type="text" placeholder="Celular" class="form-input w-full"
                                wire:model="celular" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('celular')
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
                        <div class="col-span-1">
                            <input type="text" placeholder="Email" class="form-input w-full"
                                wire:model="email" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('email')
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

                        <div class="col-span-1">
                            <input type="text" placeholder="Compañía" class="form-input w-full"
                                wire:model="compania" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('compania')
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
                        <div class="col-span-1">
                            <input type="text" placeholder="Placa vehículo" class="form-input w-full"
                                wire:model="placavehiculo" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('placavehiculo')
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
                        <div class="col-span-1">
                            <select wire:model="pais" class="form-select text-white-dark">
                                <option value="">Seleccione país de nacimiento</option>
                                <!-- Valor vacío para la opción por defecto -->
                                @foreach ($paises as $item)
                                    <option wire:key="pais-{{ $item->id }}" value="{{ $item->id }}">
                                        {{ $item->nombre }}
                                    </option>
                                    <!-- Asegúrate de usar un valor único como ID -->
                                @endforeach
                            </select>

                            <!-- Mensaje de error si no se selecciona un país válido -->
                            <div class="text-sm text-red-600 mt-2">
                                @error('pais')
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

                <!-- Sección 2 -->
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Información de emergencia y Cobertura
                        Médica</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div>
                            <!-- Select para EPS -->
                            <label for="eps" class="block text-sm font-medium text-gray-700">Seleccionar
                                EPS</label>
                            <select wire:model="eps_id" name="eps" class="form-select text-white-dark">
                                <option value="">Seleccione una EPS</option>
                                @foreach ($eps as $epsItem)
                                    <option wire:key="{{ $epsItem->id }}" value="{{ $epsItem->id }}">
                                        {{ $epsItem->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-sm text-red-600 mt-2">
                                @error('eps_id')
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

                        <div>
                            <!-- Select para ARL -->
                            <label for="arl" class="block text-sm font-medium text-gray-700">Seleccionar
                                ARL</label>
                            <select wire:model="arl_id" name="arl" class="form-select text-white-dark">
                                <option value="">Seleccione una ARL</option>
                                @foreach ($arl as $arlItem)
                                    <option wire:key="{{ $arlItem->id }}" value="{{ $arlItem->id }}">
                                        {{ $arlItem->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-sm text-red-600 mt-2">
                                @error('arl_id')
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
                        <div class="col-span-1">
                            <input type="text" placeholder="Nombre contacto emergencia" class="form-input w-full"
                                wire:model="contactoemergencia" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('contactoemergencia')
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
                        <div class="col-span-1">
                            <input type="text" placeholder="Numero contacto emergencia" class="form-input w-full"
                                wire:model="numerocontactoemergencia" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('numerocontactoemergencia')
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

                <!-- Sección 4 -->
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Captura foto del visitante</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4">
                        <div class="mb-8">
                            <!-- Contenedor para la cámara y la vista previa -->
                            <div class="flex justify-center items-center mb-4 space-x-6">
                                <!-- Video para mostrar la cámara -->
                                <div class="flex justify-center">
                                    <video id="video" class="rounded-lg shadow-md" width="300"
                                        autoplay></video>
                                </div>

                                <!-- Vista previa de la foto -->
                                <div class="flex flex-col justify-center items-center space-y-4">
                                    <canvas id="photoCanvas" class="hidden rounded-lg shadow-md" width="300"
                                        height="200"></canvas>
                                    <img wire:ignore id="photoPreview" class="hidden mt-4 rounded-lg shadow-md"
                                        width="300">
                                </div>
                            </div>

                            <!-- Botón para capturar la foto -->
                            <div class="text-center mb-6 flex justify-center items-center">
                                <button type="button"
                                    class="btn btn-primary py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-300"
                                    @click="capturePhoto()">
                                    Capturar Foto
                                </button>
                            </div>

                            <div class="text-sm text-red-600 mt-2 flex justify-center items-center">
                                @error('foto')
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

                            <!-- Botón para limpiar la foto -->
                            <div class="flex justify-center items-center mt-4">
                                @if ($foto)
                                    <button type="button"
                                        class="btn btn-outline-primary py-2 px-6 border-2 border-red-400 text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-400 rounded-lg"
                                        @click="clearPhoto()">Limpiar Foto</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div x-data="scrollHandler()" class="mb-6">
                    <!-- Caja con los términos y condiciones -->
                    <div class="relative bg-white shadow-lg rounded-lg p-6 border border-gray-200">
                        <label for="terms" class="block text-xl font-semibold text-gray-800 mb-4">Términos y
                            Condiciones</label>
                        <div class="relative mt-2 h-64 overflow-y-auto border p-4 rounded-lg bg-gray-50 text-sm text-gray-700"
                            id="terms" @scroll="checkScroll($event)">

                            <div class="mb-6 flex justify-center items-center">
                                <img src="{{ asset('assets/images/bg/politicas-2.png') }}"
                                    alt="Imagen ilustrativa de términos y condiciones"
                                    class="w-50 h-50 rounded-lg shadow-lg">
                            </div>

                            <h3 class="text-lg font-semibold text-gray-800 mb-3 relative z-10">Bienvenido:</h3>
                            <p class="mb-4 relative z-10">Antes de continuar, por favor lea los siguientes Términos y
                                Condiciones que rigen el uso de nuestros servicios. Si no está de acuerdo con los
                                términos, no podrá acceder a los mismos.</p>

                            <!-- Contenido de los términos con iconos -->
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">1. Al acceder a nuestros servicios, usted acepta cumplir con
                                        todas nuestras políticas y procedimientos.</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">2. Nuestros servicios están sujetos a cambios periódicos. Le
                                        recomendamos revisar regularmente esta página.</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">3. Nos comprometemos a proteger su privacidad y sus datos
                                        personales. Para más detalles, consulte nuestra Política de Privacidad.</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">4. El uso de nuestros servicios está prohibido para menores de
                                        edad sin la debida autorización.</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">5. El incumplimiento de los términos puede resultar en la
                                        suspensión o cancelación de su acceso a nuestros servicios.</p>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4zM12 6V4m0 12v2" />
                                    </svg>
                                    <p class="mb-2">6. Nos reservamos el derecho de modificar, suspender o
                                        descontinuar cualquier parte del servicio en cualquier momento.</p>
                                </div>
                            </div>

                            <!-- Nota final -->
                            <p class="mt-4 text-gray-600 relative z-10">Recuerde que el acceso y uso de nuestros
                                servicios implica la aceptación de estos términos. Si tiene alguna pregunta, no dude en
                                contactarnos.</p>
                        </div>
                    </div>

                    <!-- Checkbox de aceptación de términos -->
                    <div class="mb-5 py-3 flex justify-center">
                        <label class="w-12 h-6 relative">
                            <input wire:model="aceptaPolitica" x-bind:disabled="!scrolledToBottom" type="checkbox"
                                class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                id="custom_switch_checkbox1" />
                            <span for="custom_switch_checkbox1"
                                class="outline_checkbox bg-icon border-2 border-[#e6bc34] dark:border-white-dark block h-full before:absolute before:left-1 before:bg-[#e6bc34] dark:before:bg-white-dark before:bottom-1 before:w-4 before:h-4 before:bg-[{{ asset('assets/images/close.svg') }}] before:bg-no-repeat before:bg-center peer-checked:before:left-7 peer-checked:before:bg-[{{ asset('assets/images/checked.svg') }}] peer-checked:border-success peer-checked:before:bg-success before:transition-all before:duration-300">
                            </span>
                        </label>
                        <h6 class="pl-4 text-gray-800">Para continuar, debe aceptar nuestros Términos y Condiciones.
                        </h6>
                    </div>

                    <!-- Mensaje de error -->
                    <div class="text-sm text-red-600 mt-2 flex justify-center">
                        @error('aceptaPolitica')
                            <p class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <div x-data="{ mostrarFirma: @entangle('aceptaPolitica') }" x-show="mostrarFirma" x-transition.opacity>
                    <div class="mb-6">
                        <h6 class="font-semibold text-lg dark:text-white-light mb-4">Firma</h6>
                        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 justify-center items-center text-center">
                            <span class="text-sm text-gray-500">Dibuja tu firma con el mouse o el lápiz táctil.</span>
                            <div class="mb-6 flex flex-col items-center justify-center">
                                <canvas x-ref="canvas" class="border-4 border-gray-300 rounded-lg shadow-lg w-50"
                                    width="300" height="200"></canvas>
                                @if ($firma)
                                    <span class="text-green-500">Firma capturada</span>
                                @endif
                                <div class="text-sm text-red-600 mt-2">
                                    @error('firma')
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

                            <!-- Botones de Captura y Limpieza -->
                            <div class="flex justify-center items-center mb-6">
                                <button type="button"
                                    class="btn btn-outline-primary py-2 px-6 border-2 border-blue-400 text-gray-800
                                    hover:bg-gray-100 focus:ring-2 focus:ring-gray-400 rounded-lg"
                                    @click="captureSignature">
                                    Capturar Firma
                                </button>
                                <button type="button"
                                    class="btn btn-outline-primary py-2 px-6 border-2 border-red-400 text-gray-800
                                    hover:bg-gray-100 focus:ring-2 focus:ring-gray-400 rounded-lg"
                                    @click="clear()">
                                    Limpiar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Botón de envío -->
                <div class="mt-6 grid sm:grid-cols-1">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {

            Livewire.on('confirmacionGuardado', () => {
                Swal.fire({
                    title: "¡Registro Exitoso!",
                    text: "Gracias por registrarte. Ahora puedes disfrutar de todos nuestros servicios.",
                    icon: "success",
                    iconColor: "#4CAF50", // Personalización del color del icono
                    confirmButtonText: "¡Genial!",
                    confirmButtonColor: "#3085d6", // Color del botón
                    background: "#f9f9f9", // Color de fondo de la alerta
                    color: "#333", // Color del texto
                    timer: 5000, // Tiempo en ms para cerrar automáticamente la alerta
                    timerProgressBar: true,
                    showClass: {
                        popup: "animate__animated animate__fadeInDown" // Animación al aparecer
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp" // Animación al desaparecer
                    }
                });
            });


            Alpine.data('scrollHandler', () => ({
                scrolledToBottom: false,
                atBottom: false,

                checkScroll(event) {
                    const element = event.target;
                    const scrollPosition = Math.ceil(element.scrollTop + element.clientHeight);
                    const isAtBottom = scrollPosition >= element.scrollHeight;

                    if (isAtBottom) {
                        this.scrolledToBottom = true;
                        this.atBottom = true; // Marcar que se ha llegado al final
                    } else if (!isAtBottom && this.atBottom) {
                        // Solo deshabilitar el checkbox si nunca ha llegado al final
                        this.scrolledToBottom = true; // Mantener habilitado
                    } else {
                        this.scrolledToBottom = false;
                        this.atBottom = false; // No se ha llegado al final
                    }
                },
            }));


            Alpine.data('formularioVisitante', () => ({

                signaturePad: null,

                init() {
                    this.signaturePad = new SignaturePad(this.$refs.canvas);
                    this.setupCamera();

                    const canvas = this.$refs.canvas;

                    // Agregar eventos de mouse
                    canvas.addEventListener('mousedown', this.handlePointerStart.bind(this));
                    canvas.addEventListener('mousemove', this.handlePointerMove.bind(this));
                    canvas.addEventListener('mouseup', this.handlePointerEnd.bind(this));

                    // Agregar eventos táctiles
                    canvas.addEventListener('touchstart', this.handlePointerStart.bind(this), {
                        passive: false
                    });
                    canvas.addEventListener('touchmove', this.handlePointerMove.bind(this), {
                        passive: false
                    });
                    canvas.addEventListener('touchend', this.handlePointerEnd.bind(this), {
                        passive: false
                    });

                    flatpickr("#fecha_inicio", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        locale: "es",
                    });

                    flatpickr("#fecha_fin", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        locale: "es",
                    });
                },

                clear() {
                    this.signaturePad.clear();
                    @this.set('firma', '');
                },

                captureSignature() {
                    const firmaBase64 = this.signature;
                    @this.set('firma', firmaBase64);
                },

                get signature() {
                    return this.signaturePad.isEmpty() ? '' : this.signaturePad.toDataURL();
                },

                getCanvasCoords(event) {
                    const canvas = this.$refs.canvas;
                    const rect = canvas.getBoundingClientRect();
                    const isTouchEvent = event.type.startsWith('touch');
                    let x, y;

                    if (isTouchEvent && event.touches.length > 0) {
                        // Para eventos táctiles, usamos el primer toque
                        x = event.touches[0].clientX - rect.left;
                        y = event.touches[0].clientY - rect.top;
                    } else if (event.clientX && event.clientY) {
                        // Para eventos de puntero o ratón
                        x = event.clientX - rect.left;
                        y = event.clientY - rect.top;
                    } else {
                        // Si el evento no tiene las propiedades esperadas, retornar 0,0
                        x = 0;
                        y = 0;
                    }

                    return {
                        x,
                        y
                    };
                },

                handlePointerStart(event) {
                    event.preventDefault();
                    const {
                        x,
                        y
                    } = this.getCanvasCoords(event);
                    this.signaturePad._strokeBegin({
                        x,
                        y
                    });
                },

                handlePointerMove(event) {
                    event.preventDefault();
                    if (this.signaturePad && this.signaturePad
                        ._isDrawing) { // Verifica si está dibujando
                        const {
                            x,
                            y
                        } = this.getCanvasCoords(event);
                        this.signaturePad._strokeUpdate({
                            x,
                            y
                        });
                    }
                },

                handlePointerEnd(event) {
                    event.preventDefault();
                    this.signaturePad._strokeEnd();
                },

                setupCamera() {
                    const video = document.getElementById('video');
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({
                                video: true
                            })
                            .then((stream) => {
                                video.srcObject = stream;
                            })
                            .catch((err) => {
                                console.error('Error al acceder a la cámara: ', err);
                            });
                    }
                },

                capturePhoto() {
                    const video = document.getElementById('video');
                    const canvas = document.getElementById('photoCanvas');
                    const photoPreview = document.getElementById('photoPreview');
                    const context = canvas.getContext('2d');

                    // Dibuja la imagen del video en el canvas
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Muestra la imagen capturada en el img
                    const dataUrl = canvas.toDataURL('image/png');
                    photoPreview.src = dataUrl;
                    photoPreview.classList.remove('hidden');

                    // Establece el valor de la foto en Livewire
                    @this.set('foto', dataUrl);
                },

                clearPhoto() {
                    const photoPreview = document.getElementById('photoPreview');
                    photoPreview.classList.add('hidden');

                    @this.set('foto', '');

                    const photoCanvas = document.getElementById('photoCanvas');
                    const context = photoCanvas.getContext('2d');
                    context.clearRect(0, 0, photoCanvas.width, photoCanvas.height);
                    photoCanvas.classList.add('hidden');
                },

                submitForm() {
                    const firmaBase64 = this.signature;
                    const fotoBase64 = this.foto;

                    if (firmaBase64 === '') {
                        console.error('La firma está vacía');
                    }

                    @this.set('firma', firmaBase64);
                    @this.set('foto', fotoBase64);

                    this.clear();
                },
                scrollToFirstError() {
                    const firstError = document.querySelector('.text-red-600');
                    if (firstError) {
                        window.scrollTo({
                            top: firstError.offsetTop -
                                50, // Desplazamiento de 20px para margen
                            behavior: 'smooth'
                        });
                    }
                },
            }));
        });
    </script>
</div>
