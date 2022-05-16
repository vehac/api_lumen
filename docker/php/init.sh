#!/bin/bash

echo "------------------ Permissions folder ---------------------"
bash -c 'chmod -R 777 /var/www/html/storage/logs'

bash -c 'chmod -R 777 /var/www/html/public/upload'

echo "------------------ Starting apache server ------------------"
exec "apache2-foreground"