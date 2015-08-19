FROM debian:jessie

MAINTAINER Gilson Filho<me@gilsondev.in>

RUN apt-get update && apt-get install -y git curl php5-cli php5-json php5-intl php5-mysql php5-gd php5-curl

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

ADD entrypoint.sh /entrypoint.sh
ADD . /var/www/symfony

WORKDIR /var/www/symfony
# RUN cp -Rvf symfony_environment.sh /etc/profile.d/symfony.sh
# RUN sh symfony_environment.sh
RUN composer install

VOLUME /var/www/symfony
