#!/bin/sh
set -e

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan package:discover --ansi || true
php artisan storage:link || true
php artisan config:cache
php artisan migrate --force

if [ "$RUN_SEED" = "true" ]; then
  php artisan db:seed --force || true
fi

exec apache2-foreground