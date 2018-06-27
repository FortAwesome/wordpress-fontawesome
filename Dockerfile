FROM wordpress:latest

# Install packages
RUN apt-get update && \
    apt-get -y install vim subversion mysql-client

# Install xdebug
RUN pecl install xdebug && echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20170718/xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install phpunit
RUN curl -L -s  https://phar.phpunit.de/phpunit-6.phar > /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit

# Install codecept
RUN curl -LsS https://codeception.com/codecept.phar -o /usr/local/bin/codecept && chmod +x /usr/local/bin/codecept

COPY ./font-awesome/bin/install-wp-tests.sh /tmp

RUN /tmp/install-wp-tests.sh wordpress_test root somewordpress db:3306 latest true

# Xdebug environment variables
ENV XDEBUG_PORT 9000

CMD ["apache2-foreground"]
