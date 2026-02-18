<x-layouts.auth>
    @php
        $imgLight = asset('assets/images/error/maintenence-light.svg');
        $imgDark = asset('assets/images/error/maintenence-dark.svg');
    @endphp
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden">
        <div
            class="px-6 py-16 text-center font-semibold before:container before:absolute before:left-1/2 before:-translate-x-1/2 before:rounded-full before:bg-[linear-gradient(180deg,#4361EE_0%,rgba(67,97,238,0)_50.73%)] before:aspect-square before:opacity-10 md:py-20">
            <div class="relative">
                <img src="{{ $imgLight }}"
                    :src="$store.app.theme === 'dark' || $store.app.isDarkMode ? '{{ $imgDark }}' :
                        '{{ $imgLight }}'"
                    alt="503" class="mx-auto -mt-10 w-full max-w-xs object-cover md:-mt-14 md:max-w-xl" />
                <h4 class="mt-5 text-2xl font-bold dark:text-white">Estamos en mantenimiento</h4>
                <p class="text-base dark:text-white">Regresaremos en unos minutos. Gracias por tu paciencia.</p>
            </div>
        </div>
    </div>
</x-layouts.auth>
