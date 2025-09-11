FROM php:8.2-apache

RUN apt-get update \
 && apt-get install -y libicu-dev libzip-dev unzip git \
 && docker-php-ext-install intl pdo pdo_mysql zip

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
