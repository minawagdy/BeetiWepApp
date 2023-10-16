#!/bin/bash
cd /var/www/html &&
composer update && composer dump-autoload &&
chmod 777 -R storage bootstrap/cache &&
php artisan optimize:clear &&
php artisan optimize &&
php artisan migrate --force --seed
php artisan key:generate 
