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
    libcurl4-openssl-dev \
    curl \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql zip opcache \
    && pecl install raphf \
    && docker-php-ext-enable raphf \
    && pecl install pecl_http \
    && docker-php-ext-enable http

# Instalar Symfony CLI correctamente
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# Crear usuario no-root para seguridad
RUN useradd -m symfonyuser

# Cambiar al usuario antes de continuar con la instalación de Symfony
USER symfonyuser

# Crear directorio de trabajo
WORKDIR /var/www/symfony

# Copiar archivos esenciales antes de instalar dependencias
COPY --chown=symfonyuser:symfonyuser composer.json composer.lock symfony.lock ./

# Instalar dependencias sin ejecutar scripts automáticos
RUN composer install --no-interaction --no-scripts --no-autoloader --ignore-platform-reqs

# Copiar el resto del código
COPY --chown=symfonyuser:symfonyuser . .

# Asegurar permisos correctos en var/
RUN mkdir -p var && chmod -R 777 var/

# Ejecutar `composer dump-autoload` para regenerar el autoloader sin fallos
RUN composer dump-autoload --optimize

# Deshabilitar los auto-scripts de Symfony para evitar errores
RUN composer config --no-plugins allow-plugins.symfony/flex false

# Finalizar instalación de Composer (con autoloader optimizado)
RUN composer install --no-interaction --optimize-autoloader --no-scripts

# Exponer el puerto 80 para Apache
EXPOSE 80

# Ejecutar Apache en primer plano
CMD ["apache2-foreground"]