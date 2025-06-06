FROM php:8.4-fpm

RUN apt-get -y update && apt-get -y upgrade
RUN apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip unzip \
    git \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ../../src /var/www/html

RUN composer update
RUN composer --version

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN composer install

CMD ["php-fpm"]

