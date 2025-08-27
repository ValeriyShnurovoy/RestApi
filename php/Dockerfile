FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-install mbstring xml zip


RUN pecl install xdebug \
    && docker-php-ext-enable xdebug


RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.mode=develop,coverage" >> /usr/local/etc/php/conf.d/20-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/20-xdebug.ini
WORKDIR /var/www/html
