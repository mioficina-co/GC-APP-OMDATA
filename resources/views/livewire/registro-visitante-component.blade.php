<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="panel lg:col-span-2">
        <div class="mb-5">
            <form x-data="signaturePad()" wire:submit.prevent="submitSignature" x-init="init()">
                {{-- seccion numero 1 --}}
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Datos Personales</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div>
                            <select wire:model="empleado" class="form-select text-white-dark">
                                <option value="">Seleccione un empleado</option>
                                <!-- Valor vacío para opción por defecto -->
                                @foreach ($empleados as $empleadosItem)
                                    <option wire:key="$empleadosItem->id" value="{{ $empleadosItem->id }}">
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
                            <select wire:model="departamento" class="form-select text-white-dark">
                                <option value="">Seleccione un departamento</option>
                                @foreach ($departamentos as $departamentoItem)
                                    <option wire:key="$departamentoItem->id" value="{{ $departamentoItem->id }}">
                                        {{ $departamentoItem->nombre }}</option>
                                @endforeach
                            </select>

                            <!-- Mensaje de error si no se selecciona ningun departamento -->
                            <div class="text-sm text-red-600 mt-2">
                                @error('departamento')
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
                        <div>
                            <select wire:model="genero" class="form-select text-white-dark">
                                <option value="">Seleccione género</option>
                                <!-- Valor vacío para la opción por defecto -->
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="no-binario">No Binario</option>
                                <option value="otro">Otro</option>
                                <option value="prefiero-no-decirlo">Prefiero no decirlo</option>
                            </select>

                            <!-- Mensaje de error si no se selecciona un género válido -->
                            <div class="text-sm text-red-600 mt-2">
                                @error('genero')
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
                                <option value="">Seleccione país</option>
                                <!-- Valor vacío para la opción por defecto -->
                                @foreach ($paises as $item)
                                    <option wire:key="$item->id" value="{{ $item->id }}">{{ $item->nombre }}
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
                        <div class="col-span-1">
                            <input type="text" placeholder="Total personas" class="form-input w-full"
                                wire:model="totalpersonas" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('totalpersonas')
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
                    {{-- <div class="grid grid-cols-1 mt-4">
                        <textarea wire:model="pertenencias" id="ctnTextarea" rows="3" class="form-textarea w-full"
                            placeholder="Pertenencias del visitante"></textarea>
                    </div> --}}
                </div>

                <!-- Sección 2 -->
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Información de emergencia y Cobertura
                        Médica</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <input type="text" placeholder="eps" class="form-input w-full" wire:model="eps" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('eps')
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
                            <input type="text" placeholder="arl" class="form-input w-full" wire:model="arl" />
                            <div class="text-sm text-red-600 mt-2">
                                @error('arl')
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
                            <!-- Video para mostrar la cámara -->
                            <div class="flex justify-center mb-4">
                                <video id="video" class="rounded-lg shadow-md w-50 max-w-md" width="400"
                                    height="300" autoplay></video>
                            </div>

                            <!-- Botón para capturar la foto -->
                            <div class="text-center flex justify-center align-middle items-center  mb-6">
                                <button type="button"
                                    class="btn btn-primary py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-300"
                                    @click="capturePhoto()">
                                    Capturar Foto
                                </button>
                            </div>
                            <div class="text-sm text-red-600 mt-2">
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

                            <!-- Vista previa de la foto -->
                            <div class="flex flex-col justify-center items-center">
                                <canvas id="photoCanvas" class="hidden rounded-lg shadow-md" width="400"
                                    height="300"></canvas>
                                <img wire:ignore id="photoPreview" class="hidden mt-4 rounded-lg shadow-md"
                                    width="400" height="300">

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
                </div>

                <div class="mb-6">
                    <!-- Caja con los términos y condiciones -->
                    <div class="relative">
                        <label for="terms" class="block text-lg font-semibold text-gray-700">Términos y
                            Condiciones</label>
                        <div class="mt-2 h-64 overflow-y-auto border p-4 rounded-lg bg-gray-50 text-sm text-gray-700"
                            id="terms">
                            <p>
                                Aquí van los términos y condiciones. Puedes incluir todo el contenido legal necesario o
                                un resumen. Esto es solo un ejemplo.
                                <br><br>
                                Este es el contenido adicional de los términos. Añade todo lo necesario. El usuario debe
                                hacer scroll para leer todo el contenido.
                                <br><br>
                                Si el contenido es muy largo, puedes seguir agregando más texto aquí. El objetivo es que
                                el usuario llegue al final para habilitar el botón de envío.
                            </p>
                            <p>
                                Aquí van los términos y condiciones. Puedes incluir todo el contenido legal necesario o
                                un resumen. Esto es solo un ejemplo.
                                <br><br>
                                Este es el contenido adicional de los términos. Añade todo lo necesario. El usuario debe
                                hacer scroll para leer todo el contenido.
                                <br><br>
                                Si el contenido es muy largo, puedes seguir agregando más texto aquí. El objetivo es que
                                el usuario llegue al final para habilitar el botón de envío.
                            </p>
                            <p>
                                Aquí van los términos y condiciones. Puedes incluir todo el contenido legal necesario o
                                un resumen. Esto es solo un ejemplo.
                                <br><br>
                                Este es el contenido adicional de los términos. Añade todo lo necesario. El usuario debe
                                hacer scroll para leer todo el contenido.
                                <br><br>
                                Si el contenido es muy largo, puedes seguir agregando más texto aquí. El objetivo es que
                                el usuario llegue al final para habilitar el botón de envío.
                            </p>
                            <p>
                                Aquí van los términos y condiciones. Puedes incluir todo el contenido legal necesario o
                                un resumen. Esto es solo un ejemplo.
                                <br><br>
                                Este es el contenido adicional de los términos. Añade todo lo necesario. El usuario debe
                                hacer scroll para leer todo el contenido.
                                <br><br>
                                Si el contenido es muy largo, puedes seguir agregando más texto aquí. El objetivo es que
                                el usuario llegue al final para habilitar el botón de envío.
                            </p>
                            <p>
                                Aquí van los términos y condiciones. Puedes incluir todo el contenido legal necesario o
                                un resumen. Esto es solo un ejemplo.
                                <br><br>
                                Este es el contenido adicional de los términos. Añade todo lo necesario. El usuario debe
                                hacer scroll para leer todo el contenido.
                                <br><br>
                                Si el contenido es muy largo, puedes seguir agregando más texto aquí. El objetivo es que
                                el usuario llegue al final para habilitar el botón de envío.
                            </p>
                            <!-- Puedes agregar más texto aquí para hacer que el scroll sea necesario -->
                        </div>
                    </div>
                </div>

                <!-- Sección 5 -->
                <div class="mb-6">
                    <h6 class="font-semibold text-lg dark:text-white-light mb-4">Firma</h6>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 justify-center items-center text-center">
                        <!-- Canvas para la firma -->
                        <span class="text-sm text-gray-500">Dibuja tu firma con el mouse o el lápiz
                            táctil.</span>
                        <div class="mb-6 flex flex-col items-center justify-center">
                            <canvas x-ref="canvas" class="border-4 border-gray-300 rounded-lg shadow-lg w-50"
                                width="300" height="200"></canvas>
                            @if ($firma)
                                <span class="text-green-500">firma capturada</span>
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

                        <!-- Botón para limpiar la firma -->
                        <div class="flex justify-center items-center mb-6">
                            <button type="button"
                                class="btn btn-outline-primary py-2 px-6 border-2 border-blue-400 text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-400 rounded-lg"
                                @click="captureSignature">
                                Capturar Firma
                            </button>
                            <button type="button"
                                class="btn btn-outline-primary py-2 px-6 border-2 border-red-400 text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-400 rounded-lg"
                                @click="clear()">
                                Limpiar
                            </button>
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
            Alpine.data('signaturePad', () => ({
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
                }
            }));
        });
    </script>
</div>
