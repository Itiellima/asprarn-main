<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Contribuição

Obrigado por considerar contribuir com o projeto!

# ASPRARN – Sistema de Gestão da Associação de Praças da PMRN

Este sistema foi desenvolvido para atender às necessidades administrativas da Associação de Praças da Polícia Militar do Rio Grande do Norte (ASPRARN). Ele oferece funcionalidades voltadas para o cadastro e gerenciamento de associados, controle de documentação e, futuramente, gestão financeira e outros módulos administrativos.

## 🚀 Funcionalidades

- Cadastro completo de associados
- Gerenciamento de documentos e arquivos
- Autenticação segura com Laravel Breeze
- Painel administrativo com permissões
- Interface responsiva e intuitiva
- [Em desenvolvimento] Controle financeiro (mensalidades, receitas, despesas)
- [Em desenvolvimento] Relatórios gerenciais e exportação de dados

## 🛠️ Tecnologias Utilizadas

- Laravel 10 (PHP)
- MySQL
- Blade + Vite
- Laravel Breeze (autenticação)
- Bootstrap / Tailwind (dependendo do seu front-end)
- Git e GitHub para versionamento

## 📦 Instalação

```bash
git clone https://github.com/Itiellima/asprarn.git
cd asprarn
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

