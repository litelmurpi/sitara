#!/bin/bash
set -e

echo "🚀 Running deployment tasks..."

# Create .env from .env.example if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
fi

# Verify Vite build assets exist
if [ ! -f "public/build/manifest.json" ]; then
    echo "❌ Error: Vite manifest not found! Build may have failed."
    exit 1
fi
echo "✅ Vite build assets verified"

# Generate app key if not set
echo "🔑 Generating app key..."
php artisan key:generate --force --no-interaction || echo "⚠️ Key generation skipped (already set)"

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force --no-interaction || echo "⚠️ Migration failed, continuing..."

# Create storage link
php artisan storage:link --force 2>/dev/null || true

# DO NOT cache config - Railway injects env vars at runtime
echo "⚠️ Skipping config:cache (Railway uses runtime env vars)"
php artisan config:clear 2>/dev/null || true

# Cache routes and views (these are safe to cache)
php artisan route:cache
php artisan view:cache

# Seed demo data if database is empty
php artisan db:seed --class=AdminSeeder --force --no-interaction 2>/dev/null || true

echo "✅ Deployment tasks completed!"
