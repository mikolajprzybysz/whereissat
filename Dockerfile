FROM php:5.6-apache

RUN apt-get update
RUN apt-get install -y curl vim bash tar xz-utils

RUN a2enmod rewrite

ADD . /var/www/
ADD docker/opt/docker-entrypoint.sh /opt/docker-entrypoint.sh
ADD docker/apache/sites-enabled/whereissat.conf /etc/apache2/sites-enabled/000-default.conf
ADD docker/apache/conf-enabled /etc/apache2/conf-enabled
ADD docker/php/conf.d/error-log.ini /usr/local/etc/php/conf.d/error-log.ini
ADD docker/php/conf.d/timezone.ini /usr/local/etc/php/conf.d/timezone.ini
ENV ENV docker

EXPOSE 80

WORKDIR /var/www/

CMD ["/bin/bash", "/opt/docker-entrypoint.sh"]
