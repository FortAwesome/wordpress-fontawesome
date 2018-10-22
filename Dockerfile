FROM wordpress:latest

# Install packages
RUN apt-get update && \
    apt-get -y install vim subversion mysql-client less

# Install wp-cli
RUN curl -L -s https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar > /usr/local/bin/wp && chmod +x /usr/local/bin/wp

# Add non-privileged user, best for using wp-cli
RUN groupadd -r user && useradd --no-log-init -r -g user user

# Install xdebug
RUN pecl install xdebug
# Copy in our php.ini debug configuration
COPY ./docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d

# Install phpunit
RUN curl -L -s  https://phar.phpunit.de/phpunit-6.phar > /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit

COPY ./bin/install-wp-tests-docker.sh /tmp

RUN /tmp/install-wp-tests-docker.sh latest

# Xdebug environment variables
ENV XDEBUG_PORT 9000

CMD ["apache2-foreground"]
