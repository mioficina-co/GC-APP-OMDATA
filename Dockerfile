# --- ETAPA 1: Construcción de Assets (Node.js) ---
FROM node:20-alpine AS build-assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- ETAPA 2: Imagen Final (PHP 8.3 + Apache) ---
FROM php:8.3-apache

# 1. Dependencias del sistema y PHP para Laravel 11, DomPDF y CSV
# Añadimos libfreetype6-dev y libjpeg62-turbo-dev para que dompdf funcione bien con imágenes
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libonig-dev libxml2-dev \
    libpng-dev libfreetype6-dev libjpeg62-turbo-dev \
    libldap2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip ldap pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Configuración de Apache
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/apache2!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Directorio de trabajo y código
WORKDIR /var/www/html
COPY . .

# 4. Traer Composer e instalar dependencias de PHP
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 5. Traer los Assets ya compilados desde la ETAPA 1
# Esto evita tener Node.js instalado en la imagen de producción
COPY --from=build-assets /app/public/build ./public/build

# 6. Permisos (Vital para RKE2/Kubernetes)
# Jetstream y Livewire necesitan escribir en storage y cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
