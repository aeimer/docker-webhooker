# See https://hub.docker.com/r/eboraas/apache-php/

FROM eboraas/apache

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

# Install PHP7
RUN echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
    && echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list

RUN apt-get update \
    # && add-apt-repository ppa:ondrej/php \
    && apt-get install php7.0 \
    && apt-get update \
    && apt-get install -y \
        libapache2-mod-php7.0 \
        php7.0-fpm \
        php7.0-json \
        php7.0-cgi \
        php7.0-zip \
        php7.0-curl \
        php7.0-mbstring \
    && a2enmod proxy_fcgi setenvif \
    && a2enconf php7.0-fpm \
    && a2dismod php5 \
    && a2enmod php7.0
    # && apachectl restart \
    # && service apache2 reload \

RUN rm /var/www/*
COPY ./index.php /var/www/index.php

CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]