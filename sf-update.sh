#!/bin/bash

echo "Starting update for sf.dbaik.com..."

# Put application into maintenance mode
php artisan down || true

# Pull latest changes (assuming branch is main, change if necessary)
git pull origin main

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
npm install
npm run build

# Run database migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan optimize:clear
php artisan optimize
php artisan view:cache

# Restart queue workers if you are using queues
# php artisan queue:restart

# Bring application out of maintenance mode
php artisan up

echo "Update complete!"
