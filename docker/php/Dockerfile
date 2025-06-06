FROM php:8.4-fpm

RUN apt-get -y update && apt-get -y upgrade
RUN apt-get update && apt-get install -y \
    librdkafka-dev \
    libzstd-dev \
    libssl-dev \
    unzip \
    git \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libevent-dev \
    && docker-php-ext-install sockets
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
# Установка rdkafka
RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ../../src /var/www/html

RUN composer update
RUN composer --version

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]

