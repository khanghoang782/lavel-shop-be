#!/bin/sh -e

if [ -f "composer.lock" ]; then
    rm composer.lock
fi

composer install

php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan cache:clear
php artisan config:clear
php artisan route:clear
