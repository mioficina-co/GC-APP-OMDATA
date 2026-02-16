<x-guest-layout>
    <div x-data="auth">
        {{-- Fondo y decorativos --}}
        <div class="absolute inset-0 bg-gradient-to-b from-white to-blue-500">
            <img src="/assets/images/auth/bg-gradient.png" alt="Imagen de fondo"
                class="h-full w-full object-cover opacity-50" />
        </div>
        <div
            class="relative flex min-h-screen items-center justify-center bg-[url(/assets/images/auth/map.png)] bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">
            {{-- Objetos decorativos omitidos para brevedad, mantenlos igual que en tu código --}}

            <div
                class="relative flex w-full max-w-[1502px] flex-col justify-between overflow-hidden rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 lg:min-h-[758px] lg:flex-row lg:gap-10 xl:gap-0">

                {{-- Columna Izquierda (Logo e Ilustración) --}}
                <div
                    class="relative hidden w-full items-center justify-center bg-[linear-gradient(180deg,rgba(255,255,255,1)_0%,rgba(67,97,238,1)_100%)] p-5 lg:inline-flex lg:max-w-[835px] xl:-ms-32 ltr:xl:skew-x-[14deg] rtl:xl:skew-x-[-14deg]">
                    <div class="ltr:xl:-skew-x-[14deg] rtl:xl:skew-x-[14deg]">
                        <a href="/" class="w-48 block lg:w-72 ms-10">
                            <img src="/assets/images/logo_omdata.png" alt="Logo" class="w-full" />
                        </a>
                        <div class="mt-24 hidden w-full max-w-[430px] lg:block">
                            <img src="/assets/images/auth/login.svg" alt="Imagen de portada" class="w-full" />
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha (Formulario) --}}
                <div
                    class="relative flex w-full flex-col items-center justify-center gap-6 px-4 pb-16 pt-6 sm:px-6 lg:max-w-[667px]">
                    <div class="w-full max-w-[440px] lg:mt-16">
                        <div class="mb-10">
                            <h1 class="text-3xl font-extrabold uppercase !leading-snug text-primary md:text-4xl">Iniciar
                                sesión</h1>
                            <p class="text-base font-bold leading-normal text-white-dark">Ingresa tu correo electrónico
                                y contraseña para acceder</p>
                        </div>

                        {{-- 1. MENSAJES DE ESTADO (Ej: Password Reset) --}}
                        @if (session('status'))
                            <div
                                class="mb-4 p-4 rounded bg-green-500/10 text-green-500 font-bold text-sm border border-green-500/20">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- 2. ERRORES DE VALIDACIÓN (Globales) --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 rounded bg-danger/10 text-danger border border-danger/20">
                                <ul class="list-disc list-inside text-sm font-bold">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            {{-- Input Email --}}
                            <div>
                                <label for="email" class="dark:text-white">Correo Electrónico</label>
                                <div class="relative text-white-dark">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="ejemplo@correo.com"
                                        class="form-input ps-10 placeholder:text-white-dark" required autofocus
                                        autocomplete="username" />
                                    <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                            <polyline points="22,6 12,13 2,6" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            {{-- Input Contraseña --}}
                            <div>
                                <label for="password" class="dark:text-white">Contraseña</label>
                                <div class="relative text-white-dark">
                                    <input id="password" type="password" name="password" placeholder="********"
                                        class="form-input ps-10 placeholder:text-white-dark" required
                                        autocomplete="current-password" />
                                    <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2"
                                                ry="2" />
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            {{-- 3. RECUÉRDAME Y RECUPERAR CONTRASEÑA --}}
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="remember" id="remember_me"
                                        class="form-checkbox text-primary" />
                                    <span class="text-white-dark ml-2 font-semibold">Recordarme</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-primary font-bold hover:underline text-sm">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>

                            <button type="submit"
                                class="btn btn-gradient !mt-6 w-full border-0 uppercase shadow-[0_10px_20px_-10px_rgba(67,97,238,0.44)]">
                                Iniciar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
