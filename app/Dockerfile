FROM debian:bookworm

LABEL authors="alexander"

RUN  apt-get update \
  && apt-get install -y wkhtmltopdf 

RUN  apt-get -y update \
  && apt-get install -y php php-intl php-zip php-xml nginx php-fpm \
  && apt-get clean

COPY ./server.conf /etc/nginx/sites-available/default
EXPOSE 80

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY ./ ./
RUN composer install
RUN chmod 777 ./var -R 

CMD /etc/init.d/php8.2-fpm start && \
  nginx -g 'daemon off;'