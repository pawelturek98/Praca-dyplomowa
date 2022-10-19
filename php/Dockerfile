FROM php:8.1-fpm-buster

RUN apt update
RUN apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip
RUN docker-php-ext-install intl opcache pdo pdo_mysql
RUN pecl install apcu
RUN docker-php-ext-enable apcu
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

WORKDIR /var/www/home

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
