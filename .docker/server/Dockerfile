FROM php:8.1-apache
WORKDIR "/var/www/html"

########################################################################################################################
### DEBIAN OS ###
########################################################################################################################
########################################
### PACKAGES ###
########################################
# Install
RUN apt-get update
RUN apt-get install -y git zip unzip zlib1g-dev libzip-dev make gcc g++ libc-dev autoconf
RUN apt-get update
RUN apt-get upgrade -y
# Clear
RUN apt-get autoremove
RUN apt-get clean
#TODO: Remove temp files

########################################
### BASH ###
########################################
ADD ./os/root/.bashrc /root/.bashrc

########################################
### SCRIPTS ###
########################################
ADD ./os/scripts/* /usr/local/bin/
RUN chmod 775 /usr/local/bin/cmd-entrypoint



########################################################################################################################
### APACHE SERVER ###
########################################################################################################################
########################################
### CONFIGURATION FILES ###
########################################
# ORGINAL STRUCTURE:
# ------------------
# /etc/apache2/
#   apache2.conf
#   envvars
#   magic
#   ports.conf
#   conf-available/
#   conf-enabled/
#   mods-available/
#   mods-enabled/
#   sites-available/
#   sites-enabled/
# ----------------
# FINAL STRUCTURE:
# ----------------
#TODO:
# /etc/apache2/
#   apache2.conf
#   envvars
#   confs/
#   mods/
RUN rm /etc/apache2/apache2.conf
RUN rm /etc/apache2/ports.conf
ADD ./apache/apache2.conf /etc/apache2/apache2.conf

RUN rm /etc/apache2/sites-enabled/*
ADD ./apache/sites-enabled/main.conf /etc/apache2/sites-enabled/main.conf

########################################
### LOGS ###
########################################
# /var/log/apache2/
#   access.log
#   error.log



#########################################################################################################################
### PHP ##
#########################################################################################################################
#RUN rm /usr/local/etc/php/php.ini
ADD ./php/php.ini /usr/local/etc/php/php.ini

#########################################
### EXTENSIONS ###
#########################################
#TODO: To speed up the build. Compile the necessary files and add to the OS by Docker Copy, to avoid build download and compile.
# Check if can get the final compiled files from the current build.
RUN docker-php-source extract \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-source delete

#########################################
### XDEBUG ###
#########################################
#TODO: To speed up the build. Compile the necessary files and add to the OS by Docker Copy, to avoid build download and compile.
# Check if can get the final compiled files from the current build.
RUN pecl install -o -f xdebug-3.1.5
RUN docker-php-ext-enable xdebug
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD ./php/conf.d/docker-php-ext-xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini



########################################################################################################################
### COMPOSER ##
########################################################################################################################
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer



########################################################################################################################
### ENTRYPOINT ##
########################################################################################################################
CMD ["cmd-entrypoint"]
