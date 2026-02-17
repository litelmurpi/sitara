#!/bin/bash
set -e

echo "🚀 Running deployment tasks..."

# Verify Vite build assets exist
if [ ! -f "public/build/manifest.json" ]; then
    echo "❌ Error: Vite manifest not found! Build may have failed."
    exit 1
fi
echo "✅ Vite build assets verified"

# Generate app key if not set
php artisan key:generate --force --no-interaction 2>/dev/null || true

# Run migrations
php artisan migrate --force --no-interaction

# Create storage link
php artisan storage:link --force 2>/dev/null || true

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Seed demo data if database is empty
php artisan db:seed --class=AdminSeeder --force --no-interaction 2>/dev/null || true

echo "✅ Deployment tasks completed!"

