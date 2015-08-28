FROM php:5.4-apache

RUN apt-get update \
    && apt-get install -y git libssl-dev zlib1g-dev libicu-dev g++ php5-mysql \
    && pecl install zip \
    && echo extension=zip.so > /usr/local/etc/php/conf.d/zip.ini \
    && pecl install pdo_mysql \
    && echo extension=pdo_mysql.so > /usr/local/etc/php/conf.d/pdo_mysql.ini \
    && pecl install apcu-beta \
    && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini \
    && docker-php-ext-install zip mbstring intl pdo_mysql

ADD compose/vhost.conf /etc/apache2/sites-enabled/000-default.conf
ADD compose/php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

ADD . /var/www/symfony
WORKDIR /var/www/symfony
