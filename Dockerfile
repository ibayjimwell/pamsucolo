# ----------------------------------------------------
# STAGE 1: BUILD - Install PHP and Node dependencies
# ----------------------------------------------------
FROM php:8.2-fpm-alpine AS build

# Set the working directory
WORKDIR /app

# Install dependencies needed for Composer and Node
RUN apk add --no-cache \
    git \
    curl \
    mysql-client \
    nodejs \
    npm

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . .

# Install Node dependencies and run the Vite production build
RUN npm install
RUN npm run build

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# ----------------------------------------------------
# STAGE 2: PRODUCTION - The final, lightweight image
# ----------------------------------------------------
FROM php:8.2-fpm-alpine AS final

# Set the working directory
WORKDIR /var/www/html

# Install Nginx and other runtime tools
RUN apk add --no-cache \
    nginx \
    curl \
    mysql-client

# Copy the built application from the 'build' stage
COPY --from=build /app .

# Set up Laravel permissions (Crucial!)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration and the deployment script
COPY conf/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY scripts/00-laravel-deploy.sh /usr/local/bin/00-laravel-deploy.sh
RUN chmod +x /usr/local/bin/00-laravel-deploy.sh

# Expose the Nginx port
EXPOSE 8080

# The startup command runs the deployment script, then Nginx and FPM
CMD ["/usr/local/bin/00-laravel-deploy.sh"]