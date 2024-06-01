#!/bin/bash

# See https://github.com/docker-library/wordpress/issues/205

chown -Rf www-data:www-data /var/www/html/

DEFINES=""

if [ "$FONTAWESOME_ENV" = "development" ]; then
	DEFINES="${DEFINES} -DDEVELOPMENT"
fi

if [ "$ALLOW_PUT_REQUESTS" = "true" ]; then
	DEFINES="${DEFINES} -DAllowPutRequests"
fi

exec apache2-foreground ${DEFINES}
