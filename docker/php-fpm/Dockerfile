ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm-alpine

RUN apk update && apk add --no-cache $PHPIZE_DEPS postgresql-dev zip libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-install pdo pdo_pgsql json zip \
    && docker-php-ext-enable xdebug

CMD ["php-fpm"]
