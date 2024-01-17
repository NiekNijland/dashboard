#!/bin/bash

cd /var/www/dashboard

git reset --head

git pull

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan migrate --force

php artisan optimize
