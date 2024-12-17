#!/bin/bash
set -e

# Ejecutar composer install
composer install
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar .env si no existe

# cp .env.example .env
php artisan key:generate

# Generar APP_KEY si no existe
# if ! grep -q "APP_KEY=" .env || [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f 2)" ]; then
#     echo "Creant la key del env"
# fi

php artisan migrate:fresh --seed
# Ejecutar migraciones y seed solo si es la primera vez
# if [ ! -f /var/www/html/.migrated ]; then
#     # php artisan migrate:fresh --seed
#     touch /var/www/html/.migrated
# fi

# Iniciar el servidor
php artisan serve --host=0.0.0.0