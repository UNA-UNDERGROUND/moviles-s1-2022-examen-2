# must be run from the root of the project

FROM php:8.0-apache
WORKDIR /var/www/html

# copy all the files inside web/ to the container
COPY web/ /var/www/html/

# set the environment variable DOCKER_DISABLE_DBOILERPLATE
ENV DOCKER_DBOILERPLATE_DISABLE=1
# make a config directory inside the root of the container
RUN mkdir /config
# copy the docker/config.toml to the config directory
COPY docker/config.toml /config/DBoilerplate.toml
# and make it readable by the web user
RUN chmod -R 775 /config

## DBoiletplate configuration tool
# install python3
RUN apt-get update && apt-get install -y python3
# copy docker/config.py to the container
COPY docker/init-dboilerplate.py /init-dboilerplate.py
# and make it executable by the web user
RUN chmod -R 775 /init-dboilerplate.py

RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80
EXPOSE 443