FROM php:8.0-fpm
COPY php.ini /usr/local/etc/php/

ARG HOST_UID
ARG HOST_GID

ENV HOST_UID=${HOST_UID}
ENV HOST_GID=${HOST_GID}

RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql

COPY ./useradd.sh /usr/local/bin/useradd.sh
RUN chmod +x /usr/local/bin/useradd.sh && /usr/local/bin/useradd.sh \
    && chown student:student /var/www

#Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www

RUN composer global require "laravel/installer"

USER student
