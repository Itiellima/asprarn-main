#!/bin/bash
set -e

#Espera o MySQL ficar pronto
echo "⏳ Aguardando MySQL em $DB_HOST:$DB_PORT..."
until nc -z "$DB_HOST" "$DB_PORT"; do
echo "Ainda não está pronto, tentando novamente..."
sleep 1
done
echo "✅ MySQL está pronto!"

#Define as permissões corretas para os diretórios do Laravel
echo "Definindo permissões de diretórios..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

#Garante que o arquivo .env existe e gera a APP_KEY se não houver uma
echo "Verificando a chave da aplicação..."
if [ ! -f .env ]; then
echo "Arquivo .env não encontrado, criando a partir de .env.example..."
cp .env.example .env
fi

if ! grep -q "^APP_KEY=." .env; then
echo "🔑 Gerando APP_KEY..."
php artisan key:generate --force
fi

#Roda as migrações do banco de dados e as seeds
echo "🗄️ Rodando migrações e seeds..."
php artisan migrate --force
php artisan db:seed --force

#Limpa o cache de configuração para garantir que novas variáveis de ambiente sejam carregadas
echo "Limpando caches do Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

#Inicia o PHP-FPM
echo "🚀 Iniciando PHP-FPM..."
exec php-fpm