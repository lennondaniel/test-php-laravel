!#/usr/bin/env bash
echo "Running composer"
composer install 

echo "Generate key"
php artisan key:generate

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running seeds"
php artisan db:seed 

exec "$@"