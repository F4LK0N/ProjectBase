FROM php:8.1-apache
WORKDIR "/var/www/html"

########################################################################################################################
### DEBIAN SYSTEM ###
########################################################################################################################
#Updata Packages
RUN apt-get update
RUN apt-get install -y git zip unzip zlib1g-dev libzip-dev make gcc g++ libc-dev autoconf
RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get autoremove
RUN apt-get clean

#FileSystem Permissions
#chmod -R 0777 vendor



########################################################################################################################
### APACHE SERVER ###
########################################################################################################################
# Configuration Files #
#######################
# /etc/apache2/
#   apache.conf
#   envvars
#   magic
#   ports.conf
#   conf-available/
#   conf-enabled/
#   mods-available/
#   mods-enabled/
#   sites-available/
#   Sites-enabled/
#######################
# Log Files #
#######################
# /var/log/apache2/
#   access.log
#   error.log



#########################################################################################################################
#### PHP ##
#########################################################################################################################
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

# XDebug
RUN pecl install -o -f xdebug-3.1.5
RUN docker-php-ext-enable xdebug
ENV XDEBUG_INI_FILE=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=develop,debug,coverage" >>  ${XDEBUG_INI_FILE} \
    && echo "xdebug.discover_client_host=1" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.start_with_request=yes" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.client_port=10000" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.log=/tmp/xdebug.log" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.log_level=Communication" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.cli_color=1" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.var_display_max_data=2048" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.var_display_max_depth=10" >> ${XDEBUG_INI_FILE} \
    && echo "xdebug.var_display_max_children=512" >> ${XDEBUG_INI_FILE}



########################################################################################################################
### COMPOSER ##
########################################################################################################################
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install
#CMD composer update
#CMD composer dumpautoload



########################################################################################################################
### ENTRYPOINT ##
########################################################################################################################
#CMD /usr/local/bin/apache2-foreground
CMD ["apache2-foreground"]
