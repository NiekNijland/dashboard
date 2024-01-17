#!/bin/bash

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan migrate --force

php artisan optimize

php artisan clear

source ~/.bashrc

nvm use 20

npm i

npm run build
