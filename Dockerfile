# ----------------------------------------------------
# STAGE 1: BUILD - Install PHP and Node dependencies
# ----------------------------------------------------
FROM php:8.2-fpm-alpine AS build

# Set the working directory
WORKDIR /app

# Install build dependencies, Node, and necessary PHP extension libs
RUN apk add --no-cache --virtual .build-deps \
    # PHP extension build requirements
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    # Common tools
    git \
    curl \
    # Other tools
    mysql-client \
    bash \
    # Node/NPM for frontend build
    nodejs \
    npm 

# Install required PHP extensions (pdo_mysql is the key fix)
RUN docker-php-ext-install pdo_mysql zip gd opcache

# Remove build dependencies to keep the image smaller after extensions are built
RUN apk del .build-deps

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
    mysql-client \
    bash # Include bash here so the deployment script can execute

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