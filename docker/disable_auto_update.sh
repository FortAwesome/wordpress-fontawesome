#!/bin/bash
#
# See the notes about the official wordpress image related to "Stagic image".
# https://hub.docker.com/_/wordpress
#
# The official docker image includes a WordPress release whose version matches the image
# tag.

set -eux

cd /usr/src/wordpress

cp -s wp-config-docker.php wp-config.php

sed -i "/Add any custom values/a define\( \'WP_AUTO_UPDATE_CORE\', false\);" wp-config.php
