#!/bin/bash

# Run migrations
php artisan migrate --force

# Run serve
#php artisan serve

# Start PHP-FPM
php-fpm
