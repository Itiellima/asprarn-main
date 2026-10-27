#!/bin/sh
set -e

cd /app

if [ -z "$APP_KEY" ]; then
    echo "ERRO: APP_KEY não definida. Configure-a nas variáveis de ambiente." >&2
    exit 1
fi

# O volume montado em storage/app pode chegar vazio
mkdir -p storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

php artisan storage:link --force

# Migrations só quando pedido (RUN_MIGRATIONS=true). Nunca roda seed.
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force
fi

# Cache de config, rotas, eventos e views, lendo as variáveis de ambiente atuais
php artisan optimize

chown -R www-data:www-data storage bootstrap/cache

exec supervisord -c /etc/supervisor/conf.d/app.conf
