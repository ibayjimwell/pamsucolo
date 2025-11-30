# ----------------------------------------------------
# STAGE 1: BUILD - Install PHP and Node dependencies
# ----------------------------------------------------
FROM php:8.2-fpm-alpine AS build

# Set the working directory
WORKDIR /app

# 1. Install PERMANENT dependencies
# These are needed for the build process (npm) and deployment scripts (bash, git)
# We do NOT delete these.
RUN apk add --no-cache \
    bash \
    curl \
    git \
    mysql-client \
    nodejs \
    npm

# 2. Install TEMPORARY build dependencies for PHP extensions
# We put these in a virtual group so we can delete them later to save space
RUN apk add --no-cache --virtual .build-deps \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev

# 3. Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql zip gd opcache

# 4. Remove the temporary build dependencies (Clean up)
# Note: We are NOT removing nodejs or npm here because they were installed separately above
RUN apk del .build-deps

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . .

# 5. Frontend Build
# Now that Node/NPM are guaranteed to be present:
RUN npm install
RUN npm run build

# 6. Backend Build
# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# ----------------------------------------------------
# STAGE 2: PRODUCTION - The final, lightweight image
# ----------------------------------------------------
FROM php:8.2-fpm-alpine AS final

# Set the working directory
WORKDIR /var/www/html

# Install Nginx and runtime tools (Bash is needed for the script)
RUN apk add --no-cache \
    nginx \
    curl \
    mysql-client \
    bash

# Copy the built application from the 'build' stage
COPY --from=build /app .

# Set up Laravel permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration and the deployment script
COPY conf/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh

# Expose the Nginx port
EXPOSE 8080

# The startup command runs the deployment script
CMD ["/usr/local/bin/00-laravel-deploy.sh"]