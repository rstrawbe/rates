FROM php:8.2-fpm

RUN apt update && apt-get install -y zip unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        composer self-update --2

