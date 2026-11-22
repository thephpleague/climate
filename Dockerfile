ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-cli-alpine

RUN apk add --no-cache git zip $PHPIZE_DEPS

RUN --mount=type=bind,from=ghcr.io/php/pie:bin,source=/pie,target=/pie /pie install \
    pecl/pcov \
    --no-interaction

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
RUN git config --global --add safe.directory /app
