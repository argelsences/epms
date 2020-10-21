#!/bin/bash
composer install
composer dump-autoload
if [[ $1 == "fresh" ]]; then
  echo -e "Are you sure? this will reset the database [Y/n]\n"
  read answer
  if [[ $answer == "Y" ]]; then
    echo -e "Performing fresh install\n"
    php artisan key:generate
    php artisan passport:install
    mkdir -p storage/app/files
    php artisan storage:link 
    if [[ $2 == "seed" ]]; then
      php artisan migrate:fresh --seed
    else
      php artisan migrate:fresh
    fi 
  else
    exit;
  fi
elif [[ $1 == "production" ]]; then
  php artisan migrate --seed
fi

npm install
npm audit fix

if [[ $1 == "fresh" ]]; then
    npm run dev
fi

php artisan view:clear
php artisan cache:clear
