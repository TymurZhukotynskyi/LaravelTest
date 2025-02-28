#!/bin/bash

# Перевіряємо наявність .env, якщо немає — копіюємо з .env.example
if [ ! -f ".env" ]; then
    echo "Copying .env.example to .env..."
    cp .env.example .env
fi

# Генеруємо APP_KEY, якщо його немає або він порожній
if ! grep -q "^APP_KEY=[^[:space:]]" .env || grep -q "^APP_KEY=$" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

if [ ! -d "/var/www/database/sqlite" ]; then
    echo "Creating SQLite database directory..."
    mkdir -p /var/www/database/sqlite
fi

# Перевіряємо наявність файлу бази, якщо немає — створюємо
if [ ! -f "/var/www/database/sqlite/database.sqlite" ]; then
    echo "Creating SQLite database file..."
    touch /var/www/database/sqlite/database.sqlite
fi

echo "Running migrations..."
php artisan migrate --force --no-interaction

exec "$@"
