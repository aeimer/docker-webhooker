# See https://github.com/webdevops/Dockerfile

FROM webdevops/php-apache:ubuntu-16.04

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

RUN rm /app/html/*
COPY ./index.php /app/html/index.php

CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]