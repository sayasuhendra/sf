#!/bin/bash

# Configuration
DOMAIN="sf.dbaik.com"
APP_DIR=$(pwd)
CADDY_SNIPPET="$APP_DIR/Caddyfile.snippet"

echo "Setting up $DOMAIN at $APP_DIR..."

# 1. Install Dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

echo "Installing NPM dependencies..."
npm install
npm run build

# 2. Environment Setup
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    php artisan key:generate
    echo "Please update your .env file with database credentials and run setup again."
    exit 1
fi

# 3. Permissions
echo "Setting correct permissions..."
# PHP-FPM usually runs as www-data on Ubuntu/Debian
sudo chown -R www-data:www-data $APP_DIR/storage $APP_DIR/bootstrap/cache
sudo chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

# 4. Storage Link
echo "Linking storage..."
php artisan storage:link

# 5. Database Migration
echo "Running migrations..."
php artisan migrate --force

# 6. Caddy Configuration
echo "Generating Caddy configuration..."
cat > $CADDY_SNIPPET <<EOF
$DOMAIN {
    root * $APP_DIR/public
    php_fastcgi unix//var/run/php/php8.2-fpm.sock
    file_server
}
EOF

echo "Caddy configuration saved to $CADDY_SNIPPET"
echo "Please append the contents of $CADDY_SNIPPET to your main /etc/caddy/Caddyfile"
echo "Then reload Caddy: sudo systemctl reload caddy"
echo "(Caddy will automatically provision the SSL certificate for $DOMAIN)"

echo "Optimizing Laravel..."
php artisan optimize:clear
php artisan optimize
php artisan view:cache

echo "Setup complete!"
