#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

git config --global --add safe.directory /var/www/html >/dev/null 2>&1 || true

mkdir -p \
    bootstrap/cache \
    storage/app/private/evidence \
    storage/app/private/labs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views

if [ -f composer.json ] && [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist
fi

if [ -f artisan ]; then
    php artisan optimize:clear >/dev/null 2>&1 || true
fi

exec "$@"
