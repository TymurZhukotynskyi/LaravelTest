FROM php:8.3-fpm

RUN apt-get update --allow-insecure-repositories && apt-get install -y --allow-unauthenticated \
    libsqlite3-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN composer install --no-interaction

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
