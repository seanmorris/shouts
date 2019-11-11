FROM php:7.3.11-apache-stretch as development
MAINTAINER Sean Morris <sean@seanmorr.is>

COPY infra/backend/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN rm -rfv /var/www/html \
    && ln -s /app/public /var/www/html \
    && a2enmod rewrite \
    && pecl install redis \
    && docker-php-ext-enable redis

FROM development AS production

copy app/ /app
