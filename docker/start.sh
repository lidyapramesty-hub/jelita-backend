#!/bin/bash
set -e

# Replace LISTEN_PORT with actual PORT from Railway
sed -i "s/LISTEN_PORT/${PORT:-80}/g" /etc/nginx/sites-available/default

# Cache Laravel config
php artisan config:cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
