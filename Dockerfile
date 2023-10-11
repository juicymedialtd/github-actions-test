FROM wordpress:6.3.1-php8.2

RUN apt-get update \
    && apt-get install -y nano vim

# Configure PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN echo "memory_limit = 2G" >> $PHP_INI_DIR/conf.d/custom.ini

# Configure cron
RUN apt-get install -y cron

RUN echo "* * * * * www-data . /opt/env_exports && php /var/www/html/wp-cron.php" >> /etc/cron.d/wp-cron

# Remove sample themes and plugins
RUN rm -rf /usr/src/wordpress/wp-content/*

# Copy wordpress
COPY wordpress /usr/src/wordpress

COPY docker-entrypoint-wp.sh /usr/local/bin/

ENTRYPOINT ["/usr/local/bin/docker-entrypoint-wp.sh"]
CMD ["apache2-foreground"]

# XDebug
ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    echo "error_reporting = E_ALL & ~E_DEPRECATED" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_startup_errors = On" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_errors = On" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.mode = debug,profile" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.client_host = host.docker.internal" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.start_with_request = trigger" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.output_dir = /var/www/htdocs/.debug" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
fi ;
