FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y libzip-dev libpq-dev libmcrypt-dev libmagickwand-dev --no-install-recommends curl nano \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install zip gd pdo_mysql pdo_pgsql pgsql \
    && rm -rf /tmp/pear

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

CMD bash -c "composer install && php-fpm"
