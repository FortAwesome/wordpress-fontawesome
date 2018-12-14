#!/bin/bash

# See https://github.com/docker-library/wordpress/issues/205

chown -Rf www-data:www-data /var/www/html/

exec apache2-foreground
