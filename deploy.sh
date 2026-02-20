#!/bin/bash
# Production deployment script - run this on the server after pulling code
# Usage: bash deploy.sh   OR   chmod +x deploy.sh && ./deploy.sh

set -e

echo "==> Running Composer install (no dev)..."
composer install --no-dev --optimize-autoloader

echo "==> Installing npm dependencies..."
npm ci

echo "==> Building frontend assets for production..."
npm run build

echo "==> Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "==> Caching config for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Deployment complete. Frontend assets built in public/build/"
