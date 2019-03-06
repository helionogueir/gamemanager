#!/bin/bash

# Prepare App
/bin/chmod -Rf 0777 /var/www/app/cache
/usr/bin/composer --working-dir=/var/www/app update

# Dump Database
/usr/bin/mysql -v -hdbsql -uroot -proot < /root/db/person.sql
/usr/bin/mysql -v -hdbsql -uroot -proot < /root/db/challenge.sql

# Start PHP
service php-fpm start

# Start Nginx
nginx -g 'daemon off;'