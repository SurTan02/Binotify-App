FROM php:8.0-apache

RUN apt-get update
RUN apt-get install -y \
  libpq-dev libxml2-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install soap
RUN echo 'upload_max_filesize=16M' >> /usr/local/etc/php/conf.d/docker.ini

COPY src/ /var/www/html/