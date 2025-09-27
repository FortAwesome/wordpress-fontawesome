#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

source $DIR/../.env
source $DIR/../.env.ci

rc=`curl \
  --write-out '%{http_code}' \
  --silent \
  --output /dev/null \
  "http://$WP_DOMAIN/wp-admin/install.php?step=2" \
  --data-urlencode "weblog_title=$WP_DOMAIN"\
  --data-urlencode "user_name=$WORDPRESS_DB_USER" \
  --data-urlencode "admin_email=$WP_ADMIN_EMAIL" \
  --data-urlencode "admin_password=$WP_ADMIN_PASSWORD" \
  --data-urlencode "admin_password2=$WP_ADMIN_PASSWORD" \
  --data-urlencode "pw_weak=1"`

if [ "$rc" == "200" ]; then
  echo "SUCCESS initializing WordPress\n\tAdmin dashboard here:\n\thttp://$WP_DOMAIN/wp-admin"
else
  echo "FAIL with HTTP $rc"
  exit 1
fi
