#!/usr/bin/env bash

# check if the port variable is set
if [ -z "${PORT}" ]; then
    PORT=80
fi
# sed the port variable into the config file
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf

apache2-foreground "$@"