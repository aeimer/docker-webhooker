# See https://github.com/kstaken/dockerfile-examples/blob/master/apache-php/Dockerfile

FROM kstaken/apache2-php

MAINTAINER Alexander Eimer <alexander.eimer@gmail.com>

RUN rm /var/www/*
COPY ./index.php /var/www/html/index.php

CMD ["/usr/sbin/apache2", "-D", "FOREGROUND"]