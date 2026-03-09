<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="panel lg:col-span-2">
        @if (!$empleados->count())
        <div class="p-4 mt-4 text-red-700 bg-red-100 rounded-lg border border-red-400 shadow" role="status">
            No hay empleados registrados, en el sistema
        </div>
        @endif
        <div class="mb-5">
            <form wire:submit.prevent="submitSignature" autocomplete="off" autocapitalize="off" spellcheck="false">
                <div class="grid grid-cols-1 gap-6 pt-5 lg:grid-cols-1">
                    <!-- Card 1 -->
                    <div class="panel">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="text-lg font-semibold dark:text-white-light">Datos del visitante</h5>
                            @auth
                            <a href="{{ route('dashboard') }}" rel="external" class="btn btn-primary d-flex align-items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M15 20.6151C14.0907 20.8619 13.0736 21 12 21C8.13401 21 5 19.2091 5 17C5 14.7909 8.13401 13 12 13C15.866 13 19 14.7909 19 17C19 17.3453 18.9234 17.6804 18.7795 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Dashboard
                            </a>
                            @endauth


                        </div>
                        <div class="flex justify-center items-center mb-5">
                            <div class="max-w-[auto] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                <div class="px-6 py-7">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">

                                        <div class="col-span-1">
                                            <label for="numerodocumento">Numero de documento</label>
                                            <input id="numerodocumento" type="text" placeholder="Numero de documento de identidad" class="w-full form-input" wire:model.live.debounce.500ms="numerodocumento" pattern="^\d{6,10}$" title="El número de documento debe ser un número de entre 6 y 10 dígitos" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <!-- Spinner de búsqueda -->
                                            <div wire:loading wire:target="numerodocumento, tipodocumento" class="absolute right-3 top-10">
                                                <span class="block w-4 h-4 rounded-full border-2 animate-spin border-primary border-l-transparent"></span>
                                            </div>

                                            <!-- INDICADORES DE TEXTO (Badges) -->
                                            <div class="mt-2 h-5"> {{-- Contenedor con altura fija para evitar saltos de UI --}}
                                                @if ($busquedaRealizada)
                                                <div x-show="true" x-transition.opacity>
                                                    @if ($visitanteEncontrado)
                                                    <span class="badge badge-outline-success text-[10px] py-0.5 px-2 flex items-center gap-1 w-fit">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg>
                                                        Visitante recurrente (Datos cargados)
                                                    </span>
                                                    @else
                                                    <span class="badge badge-outline-info text-[10px] py-0.5 px-2 flex items-center gap-1 w-fit">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                            <circle cx="12" cy="12" r="10">
                                                            </circle>
                                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                                        </svg>
                                                        Nuevo visitante (Complete los datos)
                                                    </span>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('numerodocumento')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="tipodocumento">Tipo de documento</label>
                                            <select id="tipodocumento" wire:model.live="tipodocumento" name="tipodocumento" class="form-select text-white-dark">
                                                <option value="">Seleccione un tipo de documento</option>
                                                @foreach ($tipoDocumento as $tipoDocumentoItem)
                                                <option wire:key="$tipoDocumentoItem->id" value="{{ $tipoDocumentoItem->id }}">
                                                    {{ $tipoDocumentoItem->nombre }}
                                                </option>
                                                <!-- Usando el ID como valor -->
                                                @endforeach
                                            </select>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('tipodocumento')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="nombre">Nombres</label>
                                            <input id="nombre" type="text" placeholder="Nombres" class="w-full form-input" wire:model="nombre" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('nombre')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="numerodocumento">Apellidos</label>
                                            <input id="apellido" type="text" placeholder="Apellidos" class="w-full form-input" wire:model="apellido" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('apellido')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="rh" class="block text-sm font-medium text-gray-700">RH</label>
                                            <select wire:model="rh" id="rh" class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">Seleccione RH</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>

                                            <!-- Mensaje de error en caso de no seleccionar un RH válido -->
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('rh')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="celular">Celular</label>
                                            <input id="celular" type="text" placeholder="Celular" class="w-full form-input" wire:model="celular" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('celular')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="email">Email</label>
                                            <input id="email" type="text" placeholder="Email" class="w-full form-input" wire:model="email" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('email')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="pais">País de nacimiento</label>
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
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('pais')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="text-lg font-semibold dark:text-white-light">Datos de la visita</h5>

                        </div>
                        <div class="flex justify-center items-center mb-5">
                            <div class="max-w-[auto] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                <div class="px-6 py-7">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                                        <div class="col-span-1">
                                            <label for="empleado">Empleado</label>
                                            <select id="empleado" wire:model.change="empleado" class="form-select text-white-dark">
                                                <option value="">Seleccione un empleado</option>
                                                <!-- Valor vacío para opción por defecto -->
                                                @foreach ($empleados as $empleadosItem)
                                                <option wire:key="empleado-{{ $empleadosItem->id }}" value="{{ $empleadosItem->id }}">
                                                    {{ $empleadosItem->nombre }} -
                                                    {{ $empleadosItem->apellido }}</option>
                                                <!-- Usando el ID como valor -->
                                                @endforeach
                                            </select>
                                            <!-- Mensaje de error si no se selecciona ningun empleado -->
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('empleado')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="departamento">Departamento</label>
                                            <select id="departamento" wire:model="departamento" class="bg-none form-select text-white-dark" disabled>
                                                <option value="">Seleccione un departamento</option>
                                                @foreach ($departamentos as $departamentoItem)
                                                <option value="{{ $departamentoItem->id }}">
                                                    {{ $departamentoItem->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="razonvisita">Razon de la visita</label>
                                            <select id="razonvisita" wire:model.live="razonvisita" class="form-select text-white-dark">
                                                <option value="">Seleccione razón de la visita</option>
                                                @foreach ($razones as $razonesItem)
                                                <option wire:key="$razonesItem->id" value="{{ $razonesItem->id }}">
                                                    {{ $razonesItem->nombre }}</option>
                                                <!-- Usando el ID como valor -->
                                                @endforeach
                                            </select>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('razonvisita')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($esOtro)
                                        <div>
                                            <label for="otrorazonvisita">Otra razón de la visita</label>
                                            <input type="text" placeholder="Otra razón de la visita" class="w-full form-input" wire:model="otrorazonvisita" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('otrorazonvisita')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-span-1">
                                            <label for="compania">De donde nos visita</label>
                                            <input id="compania" type="text" placeholder="Compañía" class="w-full form-input" wire:model="compania" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('compania')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="placavehiculo">Placa vehículo</label>
                                            <input type="text" placeholder="Placa vehículo" class="w-full form-input" wire:model="placavehiculo" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('placavehiculo')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="pertenencias">Pertenencias del visitante</label>
                                            <textarea name="pertenencias" wire:model="pertenencias" id="pertenencias" class="w-full form-input" placeholder="Ingrese el detalle de los elementos con los que ingresa"></textarea>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('pertenencias')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="flex justify-between items-center mb-5">
                            <h5 class="text-lg font-semibold dark:text-white-light">Información de emergencia y
                                Cobertura
                                Médica</h5>

                        </div>
                        <div class="flex justify-center items-center mb-5">
                            <div class="max-w-[auto] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                <div class="px-6 py-7">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                                        <div>
                                            <label for="eps">EPS</label>
                                            <select wire:model="eps_id" name="eps" class="form-select text-white-dark">
                                                <option value="">Seleccione una EPS</option>
                                                @foreach ($eps as $epsItem)
                                                <option wire:key="{{ $epsItem->id }}" value="{{ $epsItem->id }}">
                                                    {{ $epsItem->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('eps_id')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="arl">ARL</label>
                                            <select wire:model="arl_id" name="arl" class="form-select text-white-dark">
                                                <option value="">Seleccione una ARL</option>
                                                @foreach ($arl as $arlItem)
                                                <option wire:key="{{ $arlItem->id }}" value="{{ $arlItem->id }}">
                                                    {{ $arlItem->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('arl_id')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="contactoemergencia">Contacto de emergencia</label>
                                            <input id="contactoemergencia" type="text" placeholder="Nombre contacto emergencia" class="w-full form-input" wire:model="contactoemergencia" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('contactoemergencia')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <label for="numerocontactoemergencia">Numero de contacto de
                                                emergencia</label>
                                            <input id="numerocontactoemergencia" type="text" placeholder="Numero contacto emergencia" class="w-full form-input" wire:model="numerocontactoemergencia" autocomplete="off" autocapitalize="off" spellcheck="false" />
                                            <div class="mt-2 text-sm text-red-600">
                                                @error('numerocontactoemergencia')
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div wire:ignore wire:key="foto-handler-registro" x-data="fotoHandler()">
                                <div class="flex flex-col items-center">
                                    <h5 class="mb-6 text-2xl font-extrabold text-gray-900 dark:text-white">
                                        Captura de Imagen
                                    </h5>

                                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                        <!-- Video -->
                                        <div class="flex relative flex-col items-center p-4 bg-white rounded-xl shadow-lg dark:bg-gray-800">
                                            <h6 class="mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                                Video en Vivo
                                            </h6>

                                            <div class="overflow-hidden relative w-64 h-64 rounded-full border-4" :class="faceReady ? 'border-green-400' : 'border-blue-400'">
                                                <video x-ref="video" class="object-cover w-full h-full" autoplay playsinline muted></video>

                                                <div class="flex absolute inset-0 justify-center items-center pointer-events-none">
                                                    <svg viewBox="0 0 300 300" class="w-full h-full">
                                                        <circle cx="150" cy="100" r="50" stroke="white" stroke-dasharray="8 4" fill="none" stroke-width="3" />
                                                        <path d="M100,150 C130,180 170,180 200,150" stroke="white" stroke-dasharray="8 4" fill="none" stroke-width="3" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full" :class="faceReady ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'">
                                                    <span x-text="faceMessage"></span>
                                                </span>

                                                <div class="mt-2 text-xs text-gray-500" x-show="faceScore !== null">
                                                    Confianza: <span x-text="Math.round(faceScore * 100) + '%'"></span> |
                                                    Rostros detectados: <span x-text="faceCount"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview -->
                                        <div class="flex relative flex-col items-center p-4 bg-white rounded-xl shadow-lg dark:bg-gray-800">
                                            <h6 class="mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                                Vista Previa
                                            </h6>

                                            <div class="flex overflow-hidden relative justify-center items-center w-64 h-64 rounded-full border-4 border-green-400">
                                                <template x-if="photoPreviewSrc">
                                                    <img :src="photoPreviewSrc" class="object-cover object-center w-full h-full" alt="Vista previa">
                                                </template>

                                                <template x-if="!photoPreviewSrc">
                                                    <div class="flex justify-center items-center w-full h-full">
                                                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.963 8.963 0 0012 20c2.232 0 4.282-.77 5.879-2.044M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </div>
                                                </template>

                                                <canvas x-ref="photoCanvas" class="hidden"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col justify-center items-center mt-8 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6">
                                        <button type="button" class="px-8 py-3 font-semibold text-white rounded-full transition duration-300 focus:outline-none focus:ring-2" :class="faceReady
                        ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
                        : 'bg-gray-400 cursor-not-allowed'" :disabled="!faceReady || !isDetectorReady || detectorBusy || captureInProgress" @click="capturePhoto()">
                                            Capturar Foto
                                        </button>

                                        <button type="button" class="px-8 py-3 font-semibold text-red-500 rounded-full border border-red-500 transition duration-300 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-400" @click="clearPhoto()" x-show="photoPreviewSrc">
                                            Limpiar Foto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-sm text-center text-red-600">
                                @error('foto')
                                <span class="flex justify-center items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div x-data="{ aceptaPolitica: @entangle('aceptaPolitica') }" class="mt-8">
                            <!-- Sección de Términos y Condiciones -->
                            <div x-data="scrollHandler()" class="mb-8">
                                <div class="relative p-8 bg-white rounded-xl border border-gray-200 shadow-2xl dark:bg-gray-900 dark:border-gray-700">
                                    <label class="block mb-6 text-2xl font-bold text-gray-800 dark:text-white">
                                        Términos y Condiciones
                                    </label>
                                    <div id="terms" @scroll="checkScroll($event)" class="overflow-y-auto relative p-6 mt-4 h-80 text-sm text-gray-700 bg-gray-50 rounded-xl border border-gray-100 dark:border-gray-600 dark:bg-gray-800 custom-scrollbar">
                                        <!-- Imagen ilustrativa -->
                                        <div class="flex justify-center items-center mb-6">
                                            <img src="{{ asset('assets/images/bg/politicas-2.png') }}" alt="Imagen ilustrativa de términos y condiciones" class="w-32 h-32 rounded-full shadow-md md:w-40 md:h-40">
                                        </div>
                                        <!-- CONTENIDO DINÁMICO DESDE LA BASE DE DATOS -->
                                        <div class="max-w-full prose dark:prose-invert">
                                            {!! nl2br(e($politicaVigente->contenido)) !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- Checkbox de aceptación -->
                                <div class="flex justify-center items-center mt-6">
                                    <label class="inline-flex items-center">
                                        <input wire:model="aceptaPolitica" x-bind:disabled="!scrolledToBottom" type="checkbox" class="w-6 h-6 text-blue-600 transition duration-150 ease-in-out form-checkbox">
                                        <span class="ml-3 text-lg text-gray-800 dark:text-gray-200">
                                            Acepto los Términos y Condiciones
                                        </span>
                                    </label>
                                </div>
                                <div class="mt-2 text-sm text-center text-red-600">
                                    @error('aceptaPolitica')
                                    <span class="flex justify-center items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sección de Firma (solo si se acepta la política) - Opción 4 -->
                            <div class="mt-8" x-data="firmaHandler()" x-show="aceptaPolitica" x-transition>
                                <h6 class="mb-6 text-2xl font-bold text-center text-gray-800 dark:text-white">
                                    Firma
                                </h6>
                                <div class="relative p-10 bg-gradient-to-br from-white to-gray-100 rounded-2xl border border-gray-200 shadow-2xl dark:from-gray-800 dark:to-gray-700 dark:border-gray-700">
                                    <!-- Acento icónico en la esquina -->
                                    <div class="absolute top-4 right-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                        </svg>
                                    </div>
                                    <p class="mb-6 text-lg text-center text-gray-700 dark:text-gray-300">
                                        Dibuja tu firma con el mouse o el lápiz táctil.
                                    </p>
                                    <div class="flex justify-center">
                                        <div class="relative">
                                            <canvas x-ref="canvas" class="rounded-lg border-4 border-gray-400 border-dotted shadow-lg transition-all duration-300 hover:shadow-2xl" width="300" height="200" x-bind:class="{ 'opacity-50': !aceptaPolitica }" x-bind:disabled="!aceptaPolitica"></canvas>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-center" x-show="$wire.firma">
                                        <span class="text-xl font-semibold text-green-500">Firma capturada</span>
                                    </div>
                                    <div class="flex flex-col gap-6 justify-center items-center mt-8 sm:flex-row">
                                        <button type="button" class="px-10 py-3 font-semibold text-white bg-blue-600 rounded-full transition duration-300 transform hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:scale-105" @click="captureSignature" x-bind:disabled="!aceptaPolitica">
                                            Capturar Firma
                                        </button>
                                        <button type="button" class="px-10 py-3 font-semibold text-red-500 rounded-full border border-red-500 transition duration-300 transform hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-400 hover:scale-105" @click="clear()" x-bind:disabled="!aceptaPolitica">
                                            Limpiar Firma
                                        </button>
                                    </div>
                                    <div class="mt-2 text-sm text-center text-red-600">
                                        @error('firma')
                                        <span class="flex justify-center items-center space-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7M15 12l-3-3M15 12l-3 3" />
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div x-data="scrollToError()" class="grid mt-6 sm:grid-cols-1">
                        <button type="submit" class="btn btn-primary" @click="scrollToError">Enviar</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>


<script>
    window.scrollToError = function() {
        return {
            scrollToError() {
                const firstError = document.querySelector('.text-red-600, .text-red-500, .error-message');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth'
                        , block: 'center'
                    });
                }
            }
        };
    };

    window.scrollHandler = function() {
        return {
            scrolledToBottom: false
            , atBottom: false,

            checkScroll(event) {
                const element = event.target;
                const scrollPosition = Math.ceil(element.scrollTop + element.clientHeight);
                const isAtBottom = scrollPosition >= element.scrollHeight;

                this.scrolledToBottom = isAtBottom;
                this.atBottom = isAtBottom;
            }
        };
    };

    window.firmaHandler = function() {
        return {
            signaturePad: null,

            init() {
                const canvas = this.$refs.canvas;
                if (!canvas) return;

                this.signaturePad = new SignaturePad(canvas);

                canvas.addEventListener('mousedown', this.handlePointerStart.bind(this));
                canvas.addEventListener('mousemove', this.handlePointerMove.bind(this));
                canvas.addEventListener('mouseup', this.handlePointerEnd.bind(this));

                canvas.addEventListener('touchstart', this.handlePointerStart.bind(this), {
                    passive: false
                });
                canvas.addEventListener('touchmove', this.handlePointerMove.bind(this), {
                    passive: false
                });
                canvas.addEventListener('touchend', this.handlePointerEnd.bind(this), {
                    passive: false
                });

                Livewire.on('resetFirma', () => {
                    this.clear();
                });
            },

            clear() {
                if (this.signaturePad) {
                    this.signaturePad.clear();
                }

                if (this.$wire) {
                    this.$wire.$set('firma', '');
                }
            },

            captureSignature() {
                if (!this.signaturePad || this.signaturePad.isEmpty()) {
                    if (this.$wire) {
                        this.$wire.$set('firma', '');
                    }
                    return;
                }

                const firmaBase64 = this.signaturePad.toDataURL('image/png');

                if (this.$wire) {
                    this.$wire.$set('firma', firmaBase64);
                }
            },

            getCanvasCoords(event) {
                const canvas = this.$refs.canvas;

                if (!canvas) {
                    return {
                        x: 0
                        , y: 0
                    };
                }

                const rect = canvas.getBoundingClientRect();
                const isTouchEvent = event.type.indexOf('touch') === 0;
                let x = 0;
                let y = 0;

                if (isTouchEvent && event.touches.length > 0) {
                    x = event.touches[0].clientX - rect.left;
                    y = event.touches[0].clientY - rect.top;
                } else if (typeof event.clientX !== 'undefined' && typeof event.clientY !== 'undefined') {
                    x = event.clientX - rect.left;
                    y = event.clientY - rect.top;
                }

                return {
                    x: x
                    , y: y
                };
            },

            handlePointerStart(event) {
                if (!this.signaturePad) return;

                event.preventDefault();
                const coords = this.getCanvasCoords(event);
                this.signaturePad._strokeBegin(coords);
            },

            handlePointerMove(event) {
                if (!this.signaturePad || !this.signaturePad._isDrawing) return;

                event.preventDefault();
                const coords = this.getCanvasCoords(event);
                this.signaturePad._strokeUpdate(coords);
            },

            handlePointerEnd(event) {
                if (!this.signaturePad) return;

                event.preventDefault();
                this.signaturePad._strokeEnd();
            }
        };
    };

    window.fotoHandler = function() {
        let detector = null;
        let mediaStream = null;
        let rafId = null;
        let lastVideoTime = -1;
        let lastProcessMs = 0;
        let initialized = false;
        let resetFotoRegistered = false;

        return {
            isDetectorReady: false
            , detectorBusy: false
            , captureInProgress: false
            , faceReady: false
            , faceMessage: 'Inicializando cámara...'
            , faceScore: null
            , faceCount: 0
            , photoPreviewSrc: ''
            , currentMetrics: null,

            async init() {
                if (initialized) return;
                initialized = true;

                try {
                    await this.setupCamera();
                    await this.setupDetector();
                    this.startDetectionLoop();

                    if (!resetFotoRegistered) {
                        resetFotoRegistered = true;

                        Livewire.on('resetFoto', () => {
                            this.clearPhoto(false);
                        });
                    }
                } catch (error) {
                    console.error('Error init fotoHandler:', error);
                    this.invalidateFace('No fue posible inicializar la validación facial.');
                }
            },

            async setupCamera() {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                        , width: {
                            ideal: 640
                        }
                        , height: {
                            ideal: 480
                        }
                    }
                    , audio: false
                });

                this.$refs.video.srcObject = mediaStream;
                await this.$refs.video.play();

                this.faceMessage = 'Ubique un único rostro dentro de la guía.';
            },

            async setupDetector() {
                const vision = await import('https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/vision_bundle.mjs');
                const FaceDetector = vision.FaceDetector;
                const FilesetResolver = vision.FilesetResolver;

                const filesetResolver = await FilesetResolver.forVisionTasks(
                    'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/wasm'
                );

                const modelPath = @js(asset('models/blaze_face_short_range.tflite'));

                detector = await FaceDetector.createFromOptions(filesetResolver, {
                    baseOptions: {
                        modelAssetPath: modelPath
                    }
                    , runningMode: 'VIDEO'
                    , minDetectionConfidence: 0.75
                    , minSuppressionThreshold: 0.3
                });

                this.isDetectorReady = true;
                this.faceMessage = 'Detector listo. Mire al frente.';
            },

            startDetectionLoop() {
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }

                const loop = async () => {
                    if (
                        !detector ||
                        !this.$refs.video ||
                        this.$refs.video.readyState < 2 ||
                        this.captureInProgress ||
                        this.detectorBusy
                    ) {
                        rafId = requestAnimationFrame(loop);
                        return;
                    }

                    const now = performance.now();

                    if ((now - lastProcessMs) < 120) {
                        rafId = requestAnimationFrame(loop);
                        return;
                    }

                    if (this.$refs.video.currentTime === lastVideoTime) {
                        rafId = requestAnimationFrame(loop);
                        return;
                    }

                    this.detectorBusy = true;

                    try {
                        const result = detector.detectForVideo(this.$refs.video, now);
                        const detections = (result && result.detections) ? result.detections : [];

                        this.handleDetections(
                            detections
                            , this.$refs.video.videoWidth
                            , this.$refs.video.videoHeight
                        );

                        lastVideoTime = this.$refs.video.currentTime;
                        lastProcessMs = now;
                    } catch (error) {
                        console.error('Error detectForVideo:', error);
                        this.invalidateFace('Error analizando el video.');
                    } finally {
                        this.detectorBusy = false;
                        rafId = requestAnimationFrame(loop);
                    }
                };

                rafId = requestAnimationFrame(loop);
            },

            handleDetections(detections, frameWidth, frameHeight) {
                this.faceCount = detections.length;

                if (detections.length === 0) {
                    this.invalidateFace('No se detecta ningún rostro.');
                    return;
                }

                if (detections.length > 1) {
                    this.invalidateFace('Solo debe haber un rostro en cámara.');
                    return;
                }

                const metrics = this.buildMetrics(detections[0], frameWidth, frameHeight);
                const error = this.validateMetrics(metrics);

                if (error) {
                    this.invalidateFace(error, metrics);
                    return;
                }

                this.faceReady = true;
                this.faceScore = metrics.score;
                this.currentMetrics = metrics;
                this.faceMessage = 'Rostro válido detectado (' + Math.round(metrics.score * 100) + '%).';
            },

            buildMetrics(detection, frameWidth, frameHeight) {
                const box = detection.boundingBox;

                let score = 0;
                if (detection.categories && detection.categories[0]) {
                    score = detection.categories[0].score;
                }

                const keypoints = detection.keypoints ? detection.keypoints.length : 0;

                const centerX = box.originX + (box.width / 2);
                const centerY = box.originY + (box.height / 2);

                const offsetX = Math.abs(centerX - (frameWidth / 2)) / frameWidth;
                const offsetY = Math.abs(centerY - (frameHeight / 2)) / frameHeight;
                const areaRatio = (box.width * box.height) / (frameWidth * frameHeight);

                return {
                    score: Number(score.toFixed(4))
                    , keypoints: keypoints
                    , areaRatio: areaRatio
                    , offsetX: offsetX
                    , offsetY: offsetY
                    , box: {
                        originX: Math.round(box.originX)
                        , originY: Math.round(box.originY)
                        , width: Math.round(box.width)
                        , height: Math.round(box.height)
                    }
                };
            },

            validateMetrics(metrics) {
                if (metrics.score < 0.75) {
                    return 'La confianza del rostro es baja. Mire al frente.';
                }

                if (metrics.keypoints < 6) {
                    return 'No se detecta el rostro completo.';
                }

                if (metrics.areaRatio < 0.10) {
                    return 'Acérquese un poco más a la cámara.';
                }

                if (metrics.offsetX > 0.18 || metrics.offsetY > 0.20) {
                    return 'Centre el rostro dentro de la guía.';
                }

                return null;
            },

            invalidateFace(message, metrics = null) {
                this.faceReady = false;
                this.faceScore = metrics ? metrics.score : null;
                this.currentMetrics = metrics;
                this.faceMessage = message;
            },

            async capturePhoto() {
                if (!this.faceReady || !detector || this.captureInProgress) {
                    this.syncLivewireFaceState({
                        ok: false
                        , message: 'No hay un rostro válido para capturar.'
                    });
                    return;
                }

                this.captureInProgress = true;

                try {
                    const video = this.$refs.video;
                    const canvas = this.$refs.photoCanvas;
                    const context = canvas.getContext('2d', {
                        willReadFrequently: true
                    });

                    const side = Math.min(video.videoWidth, video.videoHeight);
                    const sx = (video.videoWidth - side) / 2;
                    const sy = (video.videoHeight - side) / 2;

                    canvas.width = 480;
                    canvas.height = 480;

                    context.clearRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(video, sx, sy, side, side, 0, 0, canvas.width, canvas.height);

                    const metrics = this.currentMetrics;

                    if (!metrics) {
                        this.clearPhoto();
                        this.invalidateFace('No hay métricas válidas del rostro. Intente nuevamente.');
                        this.syncLivewireFaceState({
                            ok: false
                            , message: 'No hay métricas válidas del rostro. Intente nuevamente.'
                        });
                        return;
                    }

                    const error = this.validateMetrics(metrics);

                    if (error) {
                        this.clearPhoto();
                        this.invalidateFace(error, metrics);
                        this.syncLivewireFaceState({
                            ok: false
                            , message: error
                            , count: 1
                            , score: metrics.score
                            , box: metrics.box
                        });
                        return;
                    }

                    const dataUrl = canvas.toDataURL('image/png');

                    this.photoPreviewSrc = dataUrl;
                    this.faceReady = true;
                    this.faceScore = metrics.score;
                    this.faceCount = 1;
                    this.faceMessage = 'Foto capturada correctamente con un rostro válido.';

                    this.syncLivewireFaceState({
                        ok: true
                        , message: 'Foto validada correctamente.'
                        , count: 1
                        , score: metrics.score
                        , box: metrics.box
                        , foto: dataUrl
                    });
                } catch (error) {
                    console.error('Error capturePhoto:', error);
                    this.clearPhoto();
                    this.invalidateFace('Error validando la foto capturada.');
                    this.syncLivewireFaceState({
                        ok: false
                        , message: 'Error validando la foto capturada.'
                    });
                } finally {
                    this.captureInProgress = false;
                }
            },

            syncLivewireFaceState(payload) {
                payload = payload || {};

                if (!this.$wire) {
                    console.error('Livewire no está disponible dentro de fotoHandler.');
                    return;
                }

                this.$wire.$set('foto', payload.foto ? payload.foto : '');
                this.$wire.$set('foto_face_ok', payload.ok ? true : false);
                this.$wire.$set('foto_face_count', typeof payload.count === 'number' ? payload.count : 0);
                this.$wire.$set('foto_face_score', typeof payload.score === 'number' ? payload.score : null);
                this.$wire.$set('foto_face_box', payload.box ? payload.box : []);
                this.$wire.$set('foto_face_message', payload.message ? payload.message : null);
            },

            clearPhoto(sync) {
                if (typeof sync === 'undefined') {
                    sync = true;
                }

                this.photoPreviewSrc = '';

                const canvas = this.$refs.photoCanvas;
                if (canvas) {
                    const context = canvas.getContext('2d');
                    context.clearRect(0, 0, canvas.width, canvas.height);
                }

                if (sync) {
                    this.syncLivewireFaceState({
                        ok: false
                        , message: 'Debe capturar nuevamente una foto válida.'
                    });
                }
            },

            cleanup() {
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }

                if (mediaStream) {
                    mediaStream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    mediaStream = null;
                }

                if (detector && typeof detector.close === 'function') {
                    detector.close();
                    detector = null;
                }
            }
        };
    };

    document.addEventListener('livewire:init', () => {
        Livewire.on('confirmacionGuardado', () => {
            Swal.fire({
                title: '¡Registro Exitoso!'
                , text: 'Gracias por registrarte. Ahora puedes disfrutar de todos nuestros servicios.'
                , icon: 'success'
                , iconColor: '#4CAF50'
                , confirmButtonText: '¡Genial!'
                , confirmButtonColor: '#3085d6'
                , background: '#f9f9f9'
                , color: '#333'
                , timer: 5000
                , timerProgressBar: true
                , showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                }
                , hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        });

        Livewire.hook('message.processed', () => {
            const firstError = document.querySelector('.text-red-600, .text-red-500, .error-message');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth'
                    , block: 'center'
                });
            }
        });
    });

</script>

</div>
