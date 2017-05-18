# See https://github.com/kstaken/dockerfile-examples/blob/master/apache-php/Dockerfile

FROM eboraas/apache

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

# Install PHP7
RUN sudo apt-get update \
    && sudo add-apt-repository ppa:ondrej/php \
    && sudo apt-get install php7.0 \
    sudo apt-get update \
    sudo apt-get install \
        libapache2-mod-php7.0 \
        php7.0-fpm \
        php7.0-json \
        php7.0-cgi \
        php7.0-zip \
        php7.0-curl \
        php7.0-mbstring \
    && sudo a2enmod proxy_fcgi setenvif \
    && sudo a2enconf php7.0-fpm \
    && sudo a2dismod php5 \
    && sudo a2enmod php7.0
    # && sudo apachectl restart \
    # && sudo service apache2 reload \

RUN rm /var/www/*
COPY ./index.php /var/www/index.php

CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]