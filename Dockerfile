# See https://github.com/webdevops/Dockerfile

FROM webdevops/php-apache:ubuntu-16.04

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

# RUN echo 'variables_order = "EGPCS"' | tee -a /etc/php/7.0/apache/php.ini

COPY ./index.php /app/index.php
