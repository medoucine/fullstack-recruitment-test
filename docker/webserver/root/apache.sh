#!/bin/bash
# remove conf according to env
if [ "$APP_ENV" = "prod" ] || [ "$APP_ENV" = "stage" ]; then
    if [ -f /usr/local/etc/php/conf.d/custom_dev.ini ]; then
        rm /usr/local/etc/php/conf.d/custom_dev.ini
    fi
elif [ "$APP_ENV" = "dev" ] || [ "$APP_ENV" = "local" ]; then
    if [ -f /usr/local/etc/php/conf.d/custom_prod.ini ]; then
        rm /usr/local/etc/php/conf.d/custom_prod.ini
    fi
fi
# start apache server
source /etc/apache2/envvars
if [ -f /var/run/apache2/apache2.pid ]; then
    rm /var/run/apache2/apache2.pid
fi
tail -f /var/log/apache2/error.log &
exec apache2 -D FOREGROUND
