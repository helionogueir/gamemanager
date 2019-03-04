#!/bin/bash

# Prepare App
/bin/chmod -Rf 0777 /var/www/app/cache
/usr/bin/composer --working-dir=/var/www/app update

# Start PHP
service php-fpm start

# Start Nginx
nginx -g 'daemon off;'