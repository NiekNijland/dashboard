#!/bin/bash

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan migrate --force

php artisan optimize

php artisan clear

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"

nvm use 20

npm i

npm run build
