# ----------------------------------------------------
# 0. BASE STAGE: Setup PHP, Extensions & Common Tools
# ----------------------------------------------------
# We create a 'base' image that holds PHP + pdo_mysql. 
# Both the 'build' and 'final' stages will inherit from this.
FROM php:8.2-fpm-alpine AS base

WORKDIR /var/www/html

# 1. Install Runtime Dependencies (Permanent)
# These are needed for the app to run (mysql client, bash, libraries)
RUN apk add --no-cache \
    bash \
    curl \
    git \
    mysql-client \
    libpng \
    libzip \
    libxml2 \
    oniguruma

# 2. Install Build Dependencies (Temporary)
# These are needed ONLY to compile the PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    oniguruma-dev \
    $PHPIZE_DEPS

# 3. Install PHP Extensions (The Fix)
# We install pdo_mysql here so it persists in the final image
RUN docker-php-ext-install pdo_mysql zip gd opcache

# 4. Cleanup Build Dependencies
# Remove the compilers to keep the image small
RUN apk del .build-deps

# ----------------------------------------------------
# 1. BUILD STAGE: Compile Frontend & Backend
# ----------------------------------------------------
FROM base AS build

WORKDIR /app

# Install Node.js and NPM for the frontend build
RUN apk add --no-cache nodejs npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Run Vite/Tailwind build
# (npm is now guaranteed to exist in this stage)
RUN npm install
RUN npm run build

# ----------------------------------------------------
# 2. PRODUCTION STAGE: The Final Image
# ----------------------------------------------------
FROM base AS final

# Install Nginx
RUN apk add --no-cache nginx

# Copy the compiled application from the 'build' stage
COPY --from=build /app .

# Set up permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration
COPY conf/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy deployment script
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh

# Expose port
EXPOSE 8080

# Start command
CMD ["/usr/local/bin/00-laravel-deploy.sh"]