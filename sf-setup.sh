#!/bin/bash

# Configuration
DOMAIN="sf.dbaik.com"
APP_DIR=$(pwd)
NGINX_CONF="/etc/nginx/sites-available/$DOMAIN"
NGINX_LINK="/etc/nginx/sites-enabled/$DOMAIN"

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
sudo chown -R www-data:www-data $APP_DIR/storage $APP_DIR/bootstrap/cache
sudo chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

# 4. Storage Link
echo "Linking storage..."
php artisan storage:link

# 5. Database Migration
echo "Running migrations..."
php artisan migrate --force

# 6. Nginx Configuration
echo "Configuring Nginx..."
cat > $DOMAIN.conf <<EOF
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN;
    root $APP_DIR/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

sudo mv $DOMAIN.conf $NGINX_CONF
if [ ! -L $NGINX_LINK ]; then
    sudo ln -s $NGINX_CONF $NGINX_LINK
fi

echo "Testing Nginx configuration..."
sudo nginx -t

echo "Reloading Nginx..."
sudo systemctl reload nginx

echo "Optimizing Laravel..."
php artisan optimize:clear
php artisan optimize
php artisan view:cache

echo "Setup complete! Please configure SSL using Certbot (e.g., sudo certbot --nginx -d $DOMAIN)"
