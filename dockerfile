FROM node:22-alpine AS assets

WORKDIR /app

COPY package*.json ./
COPY vite.config.* ./
COPY resources ./resources
COPY public ./public

RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
RUN npm run build


FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize


FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    curl \
    bash \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
        exif \
        intl \
        gd \
        opcache

WORKDIR /var/www/html

COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

RUN mkdir -p /run/nginx \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]