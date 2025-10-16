#!/usr/bin/env bash
set -e
echo "Corriendo setup automático básico..."
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
echo "Setup completo. Corre: php artisan serve"
