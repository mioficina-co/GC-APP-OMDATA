<x-guest-layout>
    {{-- Fondo y decorativos --}}
    <div class="absolute inset-0 bg-gradient-to-b from-white to-blue-500">
        <img src="/assets/images/auth/bg-gradient.png" alt="Imagen de fondo"
            class="object-cover w-full h-full opacity-50" />
    </div>
    <div
        class="relative flex min-h-screen items-center justify-center bg-[url(/assets/images/auth/map.png)] bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">

        {{-- Elementos decorativos (Mantenemos los mismos del login) --}}
        <img src="/assets/images/auth/coming-soon-object1.png" alt="decor 1"
            class="absolute left-0 top-1/2 h-full max-h-[893px] -translate-y-1/2" />
        <img src="/assets/images/auth/coming-soon-object2.png" alt="decor 2"
            class="absolute left-24 top-0 h-40 md:left-[30%]" />
        <img src="/assets/images/auth/coming-soon-object3.png" alt="decor 3"
            class="absolute right-0 top-0 h-[300px]" />
        <img src="/assets/images/auth/polygon-object.svg" alt="decor 4" class="absolute bottom-0 end-[28%]" />

        <div
            class="relative flex w-full max-w-[1502px] flex-col justify-between overflow-hidden rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 lg:min-h-[758px] lg:flex-row lg:gap-10 xl:gap-0">

            {{-- Columna Izquierda (Branding) --}}
            <div
                class="relative hidden w-full items-center justify-center bg-[linear-gradient(180deg,rgba(255,255,255,1)_0%,rgba(67,97,238,1)_100%)] p-5 lg:inline-flex lg:max-w-[835px] xl:-ms-32 ltr:xl:skew-x-[14deg] rtl:xl:skew-x-[-14deg]">
                <div class="ltr:xl:-skew-x-[14deg] rtl:xl:skew-x-[14deg]">
                    <a href="/" class="block w-48 lg:w-72 ms-10">
                        <img src="/assets/images/logo_omdata.png" alt="Logo" class="w-full" />
                    </a>
                    <div class="mt-24 hidden w-full max-w-[430px] lg:block">
                        {{-- Imagen representativa de recuperación --}}
                        <img src="/assets/images/auth/reset-password.svg" alt="Recuperar" class="w-full" />
                    </div>
                </div>
            </div>

            {{-- Columna Derecha (Formulario) --}}
            <div
                class="relative flex w-full flex-col items-center justify-center gap-6 px-4 pb-16 pt-6 sm:px-6 lg:max-w-[667px]">
                <div class="w-full max-w-[440px]">
                    <div class="mb-7">
                        <h1 class="mb-2 text-3xl font-extrabold uppercase text-primary md:text-4xl">Recuperar Acceso
                        </h1>
                        <p class="text-sm font-bold text-white-dark">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>
                    </div>

                    {{-- Mensaje de estado (Link enviado con éxito) --}}
                    @if (session('status'))
                        <div
                            class="p-4 mb-4 text-xs font-bold text-green-500 rounded border bg-green-500/10 border-green-500/20">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="p-4 mb-4 rounded border bg-danger/10 text-danger border-danger/20">
                            <ul class="text-xs font-bold list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="font-semibold dark:text-white">Tu correo
                                electrónico</label>
                            <div class="relative mt-1 text-white-dark">
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    placeholder="ejemplo@omdata.cloud"
                                    class="form-input ps-10 placeholder:text-white-dark" required autofocus />
                                <span class="absolute top-1/2 -translate-y-1/2 start-4">
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

                        <button type="submit"
                            class="btn btn-gradient !mt-6 w-full border-0 uppercase shadow-[0_10px_20px_-10px_rgba(67,97,238,0.44)]">
                            {{ __('Email Password Reset Link') }}
                        </button>

                        <div class="mt-6 text-center">
                            <a href="{{ route('login') }}"
                                class="text-sm font-bold tracking-wider uppercase text-primary hover:underline">
                                Regresar al inicio de sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
