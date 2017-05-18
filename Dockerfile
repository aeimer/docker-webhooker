# See https://github.com/webdevops/Dockerfile

FROM webdevops/php-apache:ubuntu-16.04

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

ENV SUFFIX="" \
    APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_PID_FILE=/var/run/apache2/apache2$SUFFIX.pid \
    APACHE_RUN_DIR=/var/run/apache2$SUFFIX \
    APACHE_LOCK_DIR=/var/lock/apache2$SUFFIX \
    APACHE_LOG_DIR=/var/log/apache2$SUFFIX \
    LANG=C \
    WEB_DOCUMENT_ROOT=/app
    # LANG

COPY ./index.php /app/index.php

CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]
