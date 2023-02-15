FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y libpq-dev unzip libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint.sh" ]

#Nodes
FROM node:18-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME "/var/www/node_modules"
