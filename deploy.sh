#!/bin/bash

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan migrate --force

php artisan optimize

php artisan clear

npm i

npm run build
