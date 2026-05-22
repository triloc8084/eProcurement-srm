# Stage 1: Build assets
FROM node:20-alpine AS assets-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Run application
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip opcache

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy codebase
COPY . .

# Copy built assets
COPY --from=assets-builder /app/public/build ./public/build

# Setup directories and permissions for Nginx/PHP-FPM/Supervisor on Alpine
RUN mkdir -p /var/log/supervisor /var/run/nginx /var/log/nginx \
    && chown -R www-data:www-data /var/www/html /var/log/nginx /var/run/nginx /var/log/supervisor

# Clean up development files and run composer install
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
