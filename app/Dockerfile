FROM php:8.2-fpm

LABEL authors="alexander"

RUN  apt-get update \
  && apt-get install -y wkhtmltopdf

RUN  apt-get -y update \
  && apt-get install -y libicu-dev libzip-dev zip \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl zip \
  && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

CMD composer install \
    && chmod 777 ./var \
    && php-fpm