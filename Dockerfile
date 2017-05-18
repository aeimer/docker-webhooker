# See https://github.com/webdevops/Dockerfile

FROM webdevops/php-apache:ubuntu-16.04

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_PID_FILE=/var/run/apache2/apache2.pid \
    APACHE_RUN_DIR=/var/run/apache2 \
    APACHE_LOCK_DIR=/var/lock/apache2 \
    APACHE_LOG_DIR=/var/log/apache2 \
    LANG=C \
    WEB_DOCUMENT_ROOT=/app \
    WEB_DOCUMENT_INDEX=index.php
    # LANG

COPY ./index.php /app/index.php
