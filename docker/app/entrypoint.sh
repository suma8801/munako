#!/bin/bash
set -e

# vendor が無い場合は composer install を実行（初回起動時など）
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "Running composer install..."
    composer install --no-interaction --prefer-dist
fi

exec apache2-foreground
