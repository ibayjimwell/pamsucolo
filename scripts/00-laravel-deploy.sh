#!/usr/bin/env sh

# Exit immediately if a command exits with a non-zero status.
set -e

# Run database migrations
echo "Running database migrations..."
php artisan migrate:fresh --force

# Seed database
echo "Seeding database..."
php artisan db:seed --force

# --- START: CACHE CLEARING & WARMING ---

echo "Clearing all caches before optimizing..."
# 1. Clear application caches (config, route, view, general cache)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Clear the Vite manifest cache specifically (Fixes the unstyled issue)
php artisan optimize:clear 

# 3. Cache application configuration for production speed
echo "Caching configuration and routes for production..."
php artisan config:cache
php artisan route:cache

# --- END: CACHE CLEARING & WARMING ---


# Start PHP-FPM in the background
echo "Starting PHP-FPM..."
/usr/local/sbin/php-fpm -D

# Start Nginx in the foreground (Docker requirement)
echo "Starting Nginx..."
/usr/sbin/nginx -g 'daemon off;'