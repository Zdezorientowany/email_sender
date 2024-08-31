# docker/php/Dockerfile

FROM php:8.2-fpm

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip

# Instalacja rozszerzeń PHP wymaganych przez Symfony
RUN docker-php-ext-install pdo pdo_mysql intl opcache

# Instalacja Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Kopiowanie lokalnych plików aplikacji
COPY . .

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]
