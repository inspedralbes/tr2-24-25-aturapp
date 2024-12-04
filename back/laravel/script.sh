#!/bin/bash
set -e

# Ejecutar composer install
composer install

# Copiar .env si no existe
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generar APP_KEY si no existe
if ! grep -q "APP_KEY=" .env || [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f 2)" ]; then
    php artisan key:generate
fi

# Ejecutar migraciones y seed solo si es la primera vez
if [ ! -f /var/www/.migrated ]; then
    php artisan migrate:fresh --seed
    touch /var/www/.migrated
fi

# Iniciar el servidor
php artisan serve --host=0.0.0.0