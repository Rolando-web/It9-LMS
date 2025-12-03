#!/bin/bash
# Production Optimization Script for Laravel
# Run this on your production server after deployment

echo "🚀 Starting Laravel optimization..."

# 1. Clear all caches
echo "📦 Clearing caches..."
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# 2. Optimize autoloader
echo "⚡ Optimizing Composer autoloader..."
composer install --no-dev --optimize-autoloader

# 3. Cache configurations
echo "💾 Caching configuration..."
php artisan config:cache

# 4. Cache routes
echo "🛣️ Caching routes..."
php artisan route:cache

# 5. Cache views
echo "👁️ Caching views..."
php artisan view:cache

# 6. Optimize event listeners
echo "🎯 Caching events..."
php artisan event:cache

# 7. Run migrations for indexes
echo "📊 Running database migrations..."
php artisan migrate --force

# 8. Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs

echo "✅ Optimization complete!"
echo ""
echo "📝 Additional recommendations:"
echo "  - Enable OPcache in php.ini"
echo "  - Use Redis/Memcached for cache driver"
echo "  - Enable GZIP compression in web server"
echo "  - Use CDN for static assets"
echo "  - Monitor with Laravel Telescope (dev only)"
