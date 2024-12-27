#!/bin/bash

echo "Running Bash Script ......"

update-alternatives --set php /usr/bin/php8.2


a2enmod proxy_fcgi
a2enmod setenvif
a2enmod proxy
a2enmod proxy_http
a2enmod proxy_balancer
a2enmod lbmethod_byrequests
a2enmod rewrite
a2enmod proxy_fcgi

service apache2 reload
service php8.2-fpm start
