FROM php:8.0-apache

EXPOSE 80
RUN apt-get update
RUN apt-get install -y \
  libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql
COPY src/ /var/www/html/