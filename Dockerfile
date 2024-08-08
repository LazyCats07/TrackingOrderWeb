FROM php:8.2.12-apache

WORKDIR /var/www/html

# Enable mod_rewrite
RUN a2enmod rewrite

# Install necessary packages
RUN apt-get update -y && apt-get install -y libmariadb-dev

# Install mysqli extensions
RUN docker-php-ext-install mysqli

COPY . /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

USER www-data
