#!/usr/bin/env sh

# Exit immediately if a command exits with a non-zero status.
set -e

# Run database migrations
echo "Running database migrations..."
php artisan migrate:fresh --force

# Seed database
echo "Seeding database..."
php artisan db:seed --force

# Clear and cache application configuration
echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache

# Start PHP-FPM in the background
echo "Starting PHP-FPM..."
/usr/local/sbin/php-fpm -D

# Start Nginx in the foreground (Docker requirement)
echo "Starting Nginx..."
/usr/sbin/nginx -g 'daemon off;'
