# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zlib1g-dev \
    libxml2-dev \
    libonig-dev \
    libssl-dev \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql zip opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www/symfony

# Copiar archivos esenciales antes de instalar dependencias
COPY composer.json composer.lock symfony.lock ./

# Instalar dependencias de Symfony como root antes de copiar el resto del código
RUN composer install --no-interaction --no-scripts --no-autoloader --ignore-platform-reqs || true

# Copiar el resto de los archivos del proyecto
COPY . .

# Asegurar que el directorio var/ existe antes de aplicar permisos
RUN mkdir -p var && chmod -R 777 var/

# Finalizar instalación de Composer (ahora con todos los archivos disponibles)
RUN composer install --no-interaction --optimize-autoloader

# Crear un usuario no root para ejecutar la aplicación
RUN useradd -m symfonyuser && \
    chown -R symfonyuser:symfonyuser /var/www/symfony

# Cambiar a usuario no-root
USER symfonyuser

# Configurar Symfony para desarrollo
ENV APP_ENV=dev

# Configurar Volumes para cambios en caliente
VOLUME ["/var/www/symfony"]

# Exponer el puerto 80 para Apache
EXPOSE 80

# Ejecutar Apache en primer plano
CMD ["apache2-foreground"]
