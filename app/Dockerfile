FROM debian:bookworm

LABEL authors="alexander"

RUN  apt-get update \
  && apt-get install -y wkhtmltopdf 

RUN  apt-get -y update \
  && apt-get install -y php php-intl php-zip php-xml \
  && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www/html
COPY ./ ./
RUN composer install
RUN chmod 777 ./var -R 

RUN apt-get update && apt-get install -y nginx php-fpm && apt-get clean
COPY ./server.conf /etc/nginx/sites-available/default
EXPOSE 80

RUN chmod +x ./start.sh
CMD ./start.sh