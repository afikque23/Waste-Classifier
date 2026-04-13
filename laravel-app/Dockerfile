# Laravel demo container (SQLite + built-in server)
FROM php:8.3-cli-bookworm

# System deps + PHP extensions commonly required by Laravel + dompdf
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        sqlite3 \
        libsqlite3-dev \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        intl \
        mbstring \
        pdo_sqlite \
        zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader \
    && (test -f .env || cp .env.example .env) \
    && php artisan key:generate --force \
    && mkdir -p database \
    && test -f database/database.sqlite || touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database \
    && chown -R www-data:www-data storage bootstrap/cache database

USER www-data

ENV PORT=8000
EXPOSE 8000

CMD ["sh", "-lc", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}"]
