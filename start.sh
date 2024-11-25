#!/bin/bash

# Wait for MySQL to be ready
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    echo "Waiting for MySQL..."
    sleep 2
done

# Run database migrations
php artisan migrate --force

# Start Apache in foreground
apache2-foreground