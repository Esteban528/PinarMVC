FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

RUN mkdir -p /var/www/html/public/images/img/
RUN chown -R www-data:www-data /var/www/html/public/images/img/
RUN chmod -R 755 /var/www/html/public/images/img/

VOLUME /var/www/html
VOLUME /usr/local/etc/php
VOLUME /etc/apache2/sites-available
