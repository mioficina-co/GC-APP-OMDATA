<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="bg-white dark:bg-[#0e1726] h-full">
            <!-- Cabecera con logo y botón colapsar -->
            <div class="flex justify-between items-center px-4 py-3">
                <a href="/" class="flex items-center main-logo shrink-0">
                    <img class="w-20 ml-[5px] flex-none" src="/assets/images/logo_sm_omdata-alt.png" alt="image" />
                    <span
                        class="text-2xl font-semibold align-middle ltr:ml-1.5 rtl:mr-1.5 lg:inline dark:text-white-light">GC-APP</span>
                </a>
                <a href="javascript:;"
                    class="flex items-center w-8 h-8 rounded-full transition duration-300 collapse-icon hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light rtl:rotate-180"
                    @click="$store.app.toggleSidebar()">
                    <svg class="m-auto w-5 h-5" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

            <!-- Lista de navegación -->
            <ul
                class="perfect-scrollbar relative font-semibold space-y-0.5 h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden p-4 py-0">
                <!-- Dashboard -->
                <li class="menu nav-item">
                    <a href="{{ route('dashboard') }}" wire:navigate class="nav-link group"
                        :class="{ 'active': isActive('dashboard') }">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': isActive('dashboard') }" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5"
                                    d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                    fill="currentColor" />
                                <path
                                    d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Panel</span>
                        </div>
                    </a>
                </li>

                <!-- Separador Gestión -->
                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">
                    <svg class="hidden flex-none w-4 h-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Gestión</span>
                </h2>

                <!-- Dropdown Perfil -->
                <li class="menu nav-item">
                    <button type="button" class="nav-link group" :class="{ 'active': activeDropdown === 'perfil' }"
                        @click="activeDropdown = (activeDropdown === 'perfil' ? null : 'perfil')">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': activeDropdown === 'perfil' }" width="20"
                                height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor" />
                                <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3"
                                    fill="currentColor" />
                                <circle cx="9.00098" cy="6" r="4" fill="currentColor" />
                                <ellipse cx="9.00098" cy="17.001" rx="7" ry="4"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Perfil</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'perfil' }">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'perfil'" x-collapse class="text-gray-500 sub-menu">
                        <li>
                            <a href="{{ route('perfil.ver') }}" wire:navigate
                                :class="{ 'active': isActive('perfil.ver') }">Ver mi perfil</a>
                        </li>
                    </ul>
                </li>

                <!-- Separador Usuarios -->
                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">
                    <svg class="hidden flex-none w-4 h-5" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Usuarios</span>
                </h2>

                <!-- Dropdown Visitantes -->
                <li class="menu nav-item">
                    <button type="button" class="nav-link group"
                        :class="{ 'active': activeDropdown === 'visitantes' }"
                        @click="activeDropdown = (activeDropdown === 'visitantes' ? null : 'visitantes')">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': activeDropdown === 'visitantes' }" width="20"
                                height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor" />
                                <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3"
                                    fill="currentColor" />
                                <circle cx="9.00098" cy="6" r="4" fill="currentColor" />
                                <ellipse cx="9.00098" cy="17.001" rx="7" ry="4"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Visitantes</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'visitantes' }">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'visitantes'" x-collapse class="text-gray-500 sub-menu">
                        <li>
                            <a href="{{ route('visitantes.create') }}" wire:navigate
                                :class="{ 'active': isActive('visitantes.create') }">Registro visitantes</a>
                        </li>
                        <li>
                            <a href="{{ route('visitantes.listar') }}" wire:navigate
                                :class="{ 'active': isActive('visitantes.listar') }">Ver visitantes</a>
                        </li>
                    </ul>
                </li>

                <!-- Dropdown Empleados -->
                <li class="menu nav-item">
                    <button type="button" class="nav-link group"
                        :class="{ 'active': activeDropdown === 'empleados' }"
                        @click="activeDropdown = (activeDropdown === 'empleados' ? null : 'empleados')">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': activeDropdown === 'empleados' }" width="20"
                                height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor" />
                                <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3"
                                    fill="currentColor" />
                                <circle cx="9.00098" cy="6" r="4" fill="currentColor" />
                                <ellipse cx="9.00098" cy="17.001" rx="7" ry="4"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Empleados</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'empleados' }">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'empleados'" x-collapse class="text-gray-500 sub-menu">
                        <li>
                            <a href="{{ route('empleados.create') }}" wire:navigate
                                :class="{ 'active': isActive('empleados.create') }">Registro empleados</a>
                        </li>
                        <li>
                            <a href="{{ route('empleados.listar') }}" wire:navigate
                                :class="{ 'active': isActive('empleados.listar') }">Ver empleados</a>
                        </li>
                    </ul>
                </li>

                <!-- Separador Parametrización -->
                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">
                    <svg class="hidden flex-none w-4 h-5" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Parametrización</span>
                </h2>

                <!-- Dropdown Políticas -->
                <li class="menu nav-item">
                    <button type="button" class="nav-link group"
                        :class="{ 'active': activeDropdown === 'politica' }"
                        @click="activeDropdown = (activeDropdown === 'politica' ? null : 'politica')">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': activeDropdown === 'politica' }" width="20"
                                height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor" />
                                <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3"
                                    fill="currentColor" />
                                <circle cx="9.00098" cy="6" r="4" fill="currentColor" />
                                <ellipse cx="9.00098" cy="17.001" rx="7" ry="4"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Políticas</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'politica' }">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'politica'" x-collapse class="text-gray-500 sub-menu">
                        <li>
                            <a href="{{ route('politicas.registro') }}" wire:navigate
                                :class="{ 'active': isActive('politicas.registro') }">Registro políticas</a>
                        </li>
                        <li>
                            <a href="{{ route('politicas.listar') }}" wire:navigate
                                :class="{ 'active': isActive('politicas.listar') }">Ver políticas</a>
                        </li>
                    </ul>
                </li>

                <!-- Separador Visitas -->
                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">
                    <svg class="hidden flex-none w-4 h-5" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Visitas</span>
                </h2>

                <!-- Dropdown Visitas -->
                <li class="menu nav-item">
                    <button type="button" class="nav-link group"
                        :class="{ 'active': activeDropdown === 'visitas' }"
                        @click="activeDropdown = (activeDropdown === 'visitas' ? null : 'visitas')">
                        <div class="flex items-center">
                            <svg class="group-hover:!text-primary shrink-0"
                                :class="{ '!text-primary': activeDropdown === 'visitas' }" width="20"
                                height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor" />
                                <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3"
                                    fill="currentColor" />
                                <circle cx="9.00098" cy="6" r="4" fill="currentColor" />
                                <ellipse cx="9.00098" cy="17.001" rx="7" ry="4"
                                    fill="currentColor" />
                            </svg>
                            <span
                                class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Visitas</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'visitas' }">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'visitas'" x-collapse class="text-gray-500 sub-menu">
                        <li>
                            <a href="{{ route('visitas.listar') }}" wire:navigate
                                :class="{ 'active': isActive('visitas.listar') }">Ver visitas</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("sidebar", () => ({
                activeDropdown: null,

                // Mapa de rutas (path) a identificadores de dropdowns
                routeDropdownMap: {
                    '/configuracion/perfil': 'perfil',
                    '/verVisitantes': 'visitantes',
                    '/registroEmpleado': 'empleados',
                    '/verEmpleados': 'empleados',
                    '/registroPoliticas': 'politica',
                    '/configuracion/politicas': 'politica',
                    '/verVisitas': 'visitas',
                },

                // Abre el dropdown correcto según la URL actual
                setActiveDropdownFromRoute() {
                    const path = window.location.pathname;
                    let found = null;
                    for (const [routePath, dropdownId] of Object.entries(this.routeDropdownMap)) {
                        if (path === routePath || path.startsWith(routePath)) {
                            found = dropdownId;
                            break;
                        }
                    }
                    this.activeDropdown = found;
                },

                // Verifica si un enlace (por nombre de ruta) está activo
                isActive(routeName) {
                    const routeMap = {
                        'dashboard': '/dashboard',
                        'perfil.ver': '/configuracion/perfil',
                        'visitantes.create': '/registroVisitante',
                        'visitantes.listar': '/verVisitantes',
                        'empleados.create': '/registroEmpleado',
                        'empleados.listar': '/verEmpleados',
                        'politicas.registro': '/registroPoliticas',
                        'politicas.listar': '/configuracion/politicas',
                        'visitas.listar': '/verVisitas',
                    };
                    const currentPath = window.location.pathname;
                    const targetPath = routeMap[routeName] || routeName;
                    return currentPath === targetPath;
                },

                init() {
                    this.setActiveDropdownFromRoute();
                    document.addEventListener("livewire:navigated", () => {
                        this.setActiveDropdownFromRoute();
                    });
                }
            }));
        });
    </script>
</div>
