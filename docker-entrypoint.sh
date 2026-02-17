#!/bin/bash
set -e

echo "🔧 Fixing Apache MPM configuration..."
# Remove all MPM modules to prevent conflicts
rm -f /etc/apache2/mods-enabled/mpm_*.conf /etc/apache2/mods-enabled/mpm_*.load
# Enable only mpm_prefork (required for mod_php)
a2enmod mpm_prefork
a2enmod rewrite

# Railway provides a dynamic PORT - update Apache to listen on it
if [ -n "$PORT" ]; then
    echo "🔧 Configuring Apache to listen on port $PORT..."
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf
fi

# Run deployment tasks
/usr/local/bin/deploy.sh

# Start Apache
exec apache2-foreground
