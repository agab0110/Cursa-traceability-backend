#!/bin/bash

# Run migrations
php artisan migrate --force

# Start PHP-FPM server
php -fpm
