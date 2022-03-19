ARG PHP_VERSION=7.3
FROM php:${PHP_VERSION}-cli

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pecl install pcov && docker-php-ext-enable pcov; fi

# Install composer to manage PHP dependencies
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
