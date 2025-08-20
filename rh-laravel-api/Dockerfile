# 1. Imagen base de PHP (FPM para Laravel)
FROM php:8.2-fpm

# 2. Instalar dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libzip-dev \
    unzip \
    git \
    build-essential \
    pkg-config \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
       pdo_mysql mbstring xml curl zip gd \
    && docker-php-ext-enable pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Instalar Composer (desde la imagen oficial de Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copiar proyecto al contenedor
COPY . /var/www/html

# 5. Directorio de trabajo
WORKDIR /var/www/html

# 6. Instalar dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 7. Permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Puerto expuesto (no obligatorio en FPM, pero útil para debug)
EXPOSE 9000

CMD ["php-fpm"]
