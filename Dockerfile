ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-cli-alpine

RUN apk add --no-cache git zip $PHPIZE_DEPS

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pecl install pcov && docker-php-ext-enable pcov; fi

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
RUN git config --global --add safe.directory /app
