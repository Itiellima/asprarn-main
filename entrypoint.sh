#!/bin/sh

# Espera o MySQL ficar pronto
echo "⏳ Aguardando MySQL em $DB_HOST:$DB_PORT..."
until nc -z $DB_HOST $DB_PORT; do
  echo "Ainda não está pronto, tentando novamente..."
  sleep 3
done
echo "✅ MySQL está pronto!"

# Garante permissões
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Gera key se não existir
if ! grep -q "APP_KEY=" /var/www/.env || [ -z "$(grep APP_KEY= /var/www/.env | cut -d '=' -f2)" ]; then
    echo "🔑 Gerando APP_KEY..."
    php artisan key:generate --force
fi

# Roda migrations
echo "🗄️ Rodando migrations..."
php artisan migrate --force

# Sobe o PHP-FPM
exec php-fpm
