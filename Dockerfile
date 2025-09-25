# ===============================
# Etapa 1: Construção do frontend com Node.js
# ===============================
FROM node:18 AS frontend

WORKDIR /app

# Copiar apenas arquivos necessários para instalar dependências
COPY package.json package-lock.json ./
RUN npm install

# Copiar o restante do frontend e buildar
COPY . .
RUN npm run build

# ===============================
# Etapa 2: Backend PHP com Laravel
# ===============================
FROM php:8.2-fpm AS backend

# Instalação de dependências do sistema e extensões PHP comuns para Laravel
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        libonig-dev \
        git \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql bcmath mbstring \
    && rm -rf /var/lib/apt/lists/*


# Instalação do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho do Laravel
WORKDIR /var/www

# Copiar o restante do backend
COPY . .

# Copiar apenas os arquivos do backend essenciais para instalar dependências
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader


# Copiar os assets do frontend
COPY --from=frontend /app/public /var/www/public

# Ajustar permissões para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN php artisan key:generate
RUN php artisan migrate

# Expor porta PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
