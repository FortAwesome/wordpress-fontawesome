#!/bin/bash

# See https://github.com/docker-library/wordpress/issues/205

chown -Rf www-data:www-data /var/www/html/

DEFINES=""

if [ "$FONTAWESOME_ENV" = "development" ]; then
  DEFINES="${DEFINES} -DDEVELOPMENT"
fi

if [ "$ENABLE_MOD_SECURITY" = "true" ]; then
  DEFINES="${DEFINES} -DEnableModSecurity"
fi

if [ "$ALLOW_ALL_REQUESTS_FOR_FONT_AWESOME" = "true" ]; then
  DEFINES="${DEFINES} -DAllowAllRequestsForFontAwesome"
fi

exec apache2-foreground ${DEFINES}
