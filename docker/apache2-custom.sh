#!/bin/bash

# See https://github.com/docker-library/wordpress/issues/205

chown -Rf www-data:www-data /var/www/html/

if [ "$FONTAWESOME_ENV" = "development" ]; then
	exec apache2-foreground -DDEVELOPMENT
else
	exec apache2-foreground
fi
