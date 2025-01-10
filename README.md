# GC-APP-OMDATA
GC-APP-OMDATA
Software de Entrada y Salida - Versión 2.0

GC-APP-OMDATA es una aplicación web desarrollada con Laravel 11, Livewire 3 y Tailwind CSS. Este software está diseñado para gestionar el registro de entrada y salida de visitantes y empleados en una instalación o empresa. Su objetivo principal es ofrecer una interfaz intuitiva, segura y rápida para el seguimiento de la presencia de personas en tiempo real.

Características
Registro de Visitas: Permite el registro eficiente de entradas y salidas de visitantes con una interfaz optimizada.
Firma Digital: Implementación de un sistema de captura de firmas mediante la tecnología de SignaturePad.
Captura de Foto: Captura de imágenes a través de la cámara del dispositivo y visualización en tiempo real.
Autenticación y Seguridad: Sistema de autenticación robusto para garantizar el acceso adecuado a las funcionalidades del sistema.
Interfaz Resposiva: Desarrollado con Tailwind CSS para asegurar una experiencia fluida en dispositivos de escritorio y móviles.
Tiempo Real con Livewire: Interacciones dinámicas sin recarga de página gracias a Livewire 3.
Tecnologías Utilizadas
Laravel 11: Framework PHP para backend.
Livewire 3: Biblioteca para la creación de interfaces dinámicas en Laravel sin necesidad de escribir mucho JavaScript.
Tailwind CSS: Framework de CSS para el diseño flexible y personalizable de interfaces.
SignaturePad: Para la captura de firmas digitales.
Flatpickr: Selector de fechas y horas.
Requisitos
PHP >= 8.1
Laravel 11
Node.js
Composer
MySQL o cualquier base de datos compatible con Laravel
Instalación
Clona el repositorio:

bash
Copiar código
git clone https://github.com/tu-usuario/gc-app-omdata.git
Accede al directorio del proyecto:

bash
Copiar código
cd gc-app-omdata
Instala las dependencias de PHP:

bash
Copiar código
composer install
Instala las dependencias de JavaScript:

bash
Copiar código
npm install
Configura tu archivo .env con las credenciales de tu base de datos y otras configuraciones necesarias.

Realiza las migraciones:

bash
Copiar código
php artisan migrate
Ejecuta el servidor de desarrollo:

bash
Copiar código
php artisan serve
Accede a la aplicación en tu navegador en http://localhost:8000.


