<x-layouts.auth>
    @php
        // Usualmente usamos la imagen de 404 o una genérica si no existe 419
        $imgLight = asset('assets/images/error/404-light.svg');
        $imgDark = asset('assets/images/error/404-dark.svg');
    @endphp
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden">
        <div
            class="px-6 py-16 text-center font-semibold before:container before:absolute before:left-1/2 before:-translate-x-1/2 before:rounded-full before:bg-[linear-gradient(180deg,#4361EE_0%,rgba(67,97,238,0)_50.73%)] before:aspect-square before:opacity-10 md:py-20">
            <div class="relative">
                <img src="{{ $imgLight }}"
                    :src="$store.app.theme === 'dark' || $store.app.isDarkMode ? '{{ $imgDark }}' :
                        '{{ $imgLight }}'"
                    alt="419" class="mx-auto -mt-10 w-full max-w-xs object-cover md:-mt-14 md:max-w-xl" />
                <p class="mt-5 text-base dark:text-white">La página ha expirado debido a inactividad.</p>
                <button onclick="window.location.reload()"
                    class="btn btn-gradient mx-auto !mt-7 w-max border-0 uppercase shadow-none">Recargar Página</button>
            </div>
        </div>
    </div>
</x-layouts.auth>
