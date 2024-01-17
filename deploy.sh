#!/bin/bash

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan migrate --force

php artisan optimize

php artisan clear

echo $PATH

nvm use 20

npm i

npm run build
