(function () {
    const $themeConfig = {
        locale: 'es', // Ajustado a español por defecto
        theme: 'light',
        menu: 'vertical',
        layout: 'full',
        rtlClass: 'ltr',
        animation: 'animate__fadeIn', // Añadida animación por defecto
        navbar: 'navbar-sticky',
        semidark: false,
    };

    // --- FUNCIONES DE APOYO SEGURAS ---

    // Ocultar el loader de forma segura (Compatible con Carga Inicial y wire:navigate)
    const hideLoader = () => {
        const loader = document.querySelector('.screen_loader');
        if (loader) {
            loader.classList.add('animate__fadeOut');
            setTimeout(() => {
                // .remove() es más seguro y moderno que removeChild
                if (loader.parentNode) {
                    loader.remove();
                }
            }, 200);
        }
    };

    // Configurar listener de animaciones (Solo si el elemento existe en el layout actual)
    const setupAnimationListener = () => {
        const element = document.querySelector('.dvanimation');
        if (element) {
            element.addEventListener('animationend', () => {
                if (Alpine.store('app')) {
                    element.classList.remove(Alpine.store('app').animation);
                }
            }, { once: true });
        }
    };

    // Inicializar Perfect Scrollbar de forma segura
    const initPerfectScrollbar = () => {
        const container = document.querySelectorAll('.perfect-scrollbar');
        for (let i = 0; i < container.length; i++) {
            new PerfectScrollbar(container[i], {
                wheelPropagation: true,
            });
        }
    };

    // --- EVENTOS GLOBALES ---

    // Ejecución al cargar la página por primera vez (F5)
    window.addEventListener('load', function () {
        hideLoader();
        setupAnimationListener();
        if (Alpine.store('app')) {
            Alpine.store('app').setRTLLayout();
        }

        // Año del footer
        const yearEle = document.querySelector('#footer-year');
        if (yearEle) {
            yearEle.innerHTML = new Date().getFullYear();
        }
    });

    // Ejecución cada vez que Livewire navega (Navegación SPA)
    document.addEventListener('livewire:navigated', () => {
        hideLoader();
        setupAnimationListener();
        initPerfectScrollbar(); // Re-inicializar scrollbar en el nuevo contenido
    });

    // --- INICIALIZACIÓN DE ALPINE ---

    document.addEventListener('alpine:init', () => {
        initPerfectScrollbar();

        Alpine.data('collapse', () => ({
            collapse: false,
            collapseSidebar() {
                this.collapse = !this.collapse;
            },
        }));

        Alpine.data('dropdown', (initialOpenState = false) => ({
            open: initialOpenState,
            toggle() {
                this.open = !this.open;
            },
        }));

        Alpine.data('modal', (initialOpenState = false) => ({
            open: initialOpenState,
            toggle() {
                this.open = !this.open;
            },
        }));

        // Magic: $tooltip y Directivas
        Alpine.magic('tooltip', (el) => (message, placement) => {
            let instance = tippy(el, {
                content: message,
                trigger: 'manual',
                placement: placement || undefined,
                allowHTML: true,
            });
            instance.show();
        });

        Alpine.directive('tooltip', (el, { expression }) => {
            tippy(el, {
                content: expression,
                placement: el.getAttribute('data-placement') || undefined,
                allowHTML: true,
                delay: el.getAttribute('data-delay') || 0,
                animation: el.getAttribute('data-animation') || 'fade',
                theme: el.getAttribute('data-theme') || '',
            });
        });

        Alpine.data('main', (value) => ({}));

        Alpine.store('app', {
            theme: Alpine.$persist($themeConfig.theme),
            isDarkMode: Alpine.$persist(false),
            toggleTheme(val) {
                if (!val) val = this.theme || $themeConfig.theme;
                this.theme = val;
                if (this.theme == 'light') this.isDarkMode = false;
                else if (this.theme == 'dark') this.isDarkMode = true;
                else if (this.theme == 'system') {
                    this.isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
            },
            menu: Alpine.$persist($themeConfig.menu),
            toggleMenu(val) {
                if (!val) val = this.menu || $themeConfig.menu;
                this.sidebar = false;
                this.menu = val;
            },
            layout: Alpine.$persist($themeConfig.layout),
            toggleLayout(val) {
                if (!val) val = this.layout || $themeConfig.layout;
                this.layout = val;
            },
            rtlClass: Alpine.$persist($themeConfig.rtlClass),
            toggleRTL(val) {
                if (!val) val = this.rtlClass || $themeConfig.rtlClass;
                this.rtlClass = val;
                this.setRTLLayout();
            },
            setRTLLayout() {
                const html = document.querySelector('html');
                if (html) html.setAttribute('dir', this.rtlClass || $themeConfig.rtlClass);
            },
            animation: Alpine.$persist($themeConfig.animation),
            toggleAnimation(val) {
                if (!val) val = this.animation || $themeConfig.animation;
                this.animation = val?.trim();
            },
            navbar: Alpine.$persist($themeConfig.navbar),
            toggleNavbar(val) {
                if (!val) val = this.navbar || $themeConfig.navbar;
                this.navbar = val;
            },
            semidark: Alpine.$persist($themeConfig.semidark),
            toggleSemidark(val) {
                if (!val) val = this.semidark || $themeConfig.semidark;
                this.semidark = val;
            },
            locale: Alpine.$persist($themeConfig.locale),
            toggleLocale(val) {
                if (!val) val = this.locale || $themeConfig.locale;
                this.locale = val;
                this.toggleRTL(this.locale?.toLowerCase() === 'ae' ? 'rtl' : 'ltr');
            },
            sidebar: false,
            toggleSidebar() {
                this.sidebar = !this.sidebar;
            },
        });
    });
})();