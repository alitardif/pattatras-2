#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-security-blocking
fi

mkdir -p var/cache var/log
chown -R www-data:www-data var
chmod -R 775 var

if [ "${APP_ENV:-prod}" = "prod" ]; then
    php bin/console cache:clear --env=prod --no-warmup || true
    php bin/console cache:warmup --env=prod || true
    chown -R www-data:www-data var
fi

exec docker-php-entrypoint "$@"
