FROM php:8-apache as php

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY conf/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN chown -R www-data:www-data /var/www

RUN mkdir /var/www/data

RUN mkdir /var/www/data/logs

RUN chmod -R 0777 /var/www/data
RUN chmod -R 0777 /var/www/data/logs