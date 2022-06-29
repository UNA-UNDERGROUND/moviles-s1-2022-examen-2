# must be run from the root of the project

FROM php:8.0-apache
WORKDIR /var/www/html

## DBoiletplate configuration tool
# install python3
RUN apt-get update && apt-get install -y python3
# copy docker/config.py to the container
COPY docker/init-dboilerplate.py /init-dboilerplate.py
# and make it executable by the web user
RUN chmod -R 775 /init-dboilerplate.py

## Heroku
# copy the apache-heroku.py script to the container
COPY docker/apache-heroku.py /apache-heroku.py
# and make it executable by the web user
RUN chmod -R 775 /apache-heroku.py
# run the python script with python3
RUN python3 /apache-heroku.py
# Copy the run-apache2.sh script to the container
COPY docker/run-apache2.sh /run-apache2.sh
# and make it executable by the web user
RUN chmod -R 775 /run-apache2.sh

## General

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


RUN a2enmod rewrite
RUN service apache2 restart


# create a non root user
RUN useradd -s /bin/bash -m -d /var/www/html/app -g www-data app
RUN echo "app:app" | chpasswd
# set /etc/apache2/ports.conf editable by the web user
RUN chmod -R 775 /etc/apache2/ports.conf

# change to the non root user
USER app

# set it to entry command
CMD [ "/run-apache2.sh" ]


EXPOSE 80
EXPOSE 443