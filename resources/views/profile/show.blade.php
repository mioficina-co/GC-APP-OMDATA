<x-app-layout>
    <div>
        {{-- Breadcrumbs Estilo Vristo --}}
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('dashboard') }}" class="text-primary hover:underline">Escritorio</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Configuración de Cuenta</span>
            </li>
        </ul>

        <div class="pt-5" x-data="{ tab: 'general' }">
            <div class="flex justify-between items-center mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Ajustes de Perfil</h5>
            </div>

            {{-- Navegación por Pestañas --}}
            <div class="mb-5">
                <ul
                    class="sm:flex font-semibold border-b border-[#ebedf2] dark:border-[#191e3a] whitespace-nowrap overflow-y-auto">
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{ '!border-primary text-primary': tab == 'general' }" @click="tab='general'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                                <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 14.5c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5 3.5 1.567 3.5 3.5-1.567 3.5-3.5 3.5z"
                                    fill="currentColor" opacity="0.5" />
                            </svg>
                            Información General
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{ '!border-primary text-primary': tab == 'security' }" @click="tab='security'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                class="w-5 h-5 text-warning">
                                <path d="M12 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Seguridad
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{ '!border-primary text-primary': tab == 'sessions' }" @click="tab='sessions'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                                <path opacity="0.5"
                                    d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4z"
                                    stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            Sesiones de Navegador
                        </a>
                    </li>
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex gap-2 p-4 border-b border-transparent hover:border-danger hover:text-danger"
                                :class="{ '!border-danger text-danger': tab == 'danger' }" @click="tab='danger'">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                                    <path
                                        d="M18.88 15.58c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H5.12c-1.1 0-2 .9-2 2v9.58c0 1.1.9 2 2 2h13.76z"
                                        stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                                    <path d="M12 12V7m0 8h.01" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                Eliminar Cuenta
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- Contenido de las Pestañas --}}
                <div class="mt-5">

                    {{-- Tab: Información General --}}
                    <div x-show="tab === 'general'" x-transition.opacity>
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            <div class="panel">
                                @livewire('profile.update-profile-information-form')
                            </div>
                        @endif
                    </div>

                    {{-- Tab: Seguridad --}}
                    <div x-show="tab === 'security'" x-transition.opacity class="space-y-6">
                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="panel">
                                @livewire('profile.update-password-form')
                            </div>
                        @endif

                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <div class="panel">
                                @livewire('profile.two-factor-authentication-form')
                            </div>
                        @endif
                    </div>

                    {{-- Tab: Sesiones --}}
                    <div x-show="tab === 'sessions'" x-transition.opacity>
                        <div class="panel">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>
                    </div>

                    {{-- Tab: Peligro --}}
                    <div x-show="tab === 'danger'" x-transition.opacity>
                        <div class="panel border-danger">
                            <div class="flex gap-3 items-center mb-5 text-danger">
                                <h6 class="text-lg font-bold">Zona de Peligro</h6>
                            </div>
                            @livewire('profile.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
