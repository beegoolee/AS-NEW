FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        g++ \
        git \
        libicu-dev \
        zip \
        libzip-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

#RUN php bin/console doctrine:database:create
#
#RUN php bin/console make:migration
#
#RUN php bin/console doctrine:migration:migrate

#RUN php bin/console doctrine:fixtures:load

# Запускаем PHP-FPM
CMD ["php-fpm"]
