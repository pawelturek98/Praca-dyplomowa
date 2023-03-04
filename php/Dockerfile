FROM phpdockerio/php:8.1-fpm

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.1-intl \
        php8.1-mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /var/www/home

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
