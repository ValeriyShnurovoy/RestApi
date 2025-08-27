FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpq-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath pcntl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug,coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=default" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN mkdir -p /var/log/php-fpm \
    && chown -R www-data:www-data /var/log/php-fpm

WORKDIR /var/www/html
