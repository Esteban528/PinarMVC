#!/bin/bash

# Ajustar permisos de los directorios
chown -R www-data:www-data /var/www/html/public/images/img/
chmod -R 755 /var/www/html/public/images/img/

exec "$@"
