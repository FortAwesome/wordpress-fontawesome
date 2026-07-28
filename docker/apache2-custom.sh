#!/bin/bash

# See https://github.com/docker-library/wordpress/issues/205
#
# WordPress/Apache needs /var/www/html to be writable by www-data, which we
# used to guarantee with a blanket recursive chown of the whole tree:
#
#     chown -Rf www-data:www-data /var/www/html/
#
# The catch: this repo and the integration themes/plugins are bind-mounted into
# /var/www/html from the host, so a recursive chown walks into those bind mounts
# and reowns the host's working copy to www-data (uid 33). On the host that
# trips git's "dubious ownership" guard (CVE-2022-24765) and causes other
# permission friction.
#
# Set SKIP_PLUGIN_CHOWN=true to chown everything under /var/www/html EXCEPT the
# bind-mounted host paths, so the host working copy keeps its ownership. The
# excluded paths default to this plugin plus the integration mounts wired up in
# docker-compose.yml; override with CHOWN_EXCLUDE_PATHS (a colon-separated list)
# if you add or remove bind mounts there. Leave SKIP_PLUGIN_CHOWN unset to keep
# the original blanket behavior.

CHOWN_ROOT="/var/www/html"

default_excludes=(
  "$CHOWN_ROOT/wp-content/plugins"
  "$CHOWN_ROOT/wp-content/js"
  "$CHOWN_ROOT/wp-content/themes"
)

if [ "$SKIP_PLUGIN_CHOWN" = "true" ]; then
  if [ -n "$CHOWN_EXCLUDE_PATHS" ]; then
    IFS=':' read -ra excludes <<< "$CHOWN_EXCLUDE_PATHS"
  else
    excludes=("${default_excludes[@]}")
  fi

  # Build a find(1) prune expression: ( -path A -o -path B -o ... )
  prune=()
  for path in "${excludes[@]}"; do
    [ -n "$path" ] || continue
    [ ${#prune[@]} -eq 0 ] || prune+=( -o )
    prune+=( -path "$path" )
  done

  if [ ${#prune[@]} -gt 0 ]; then
    # Skip (don't descend into) the excluded bind-mount paths, chown the rest.
    find "$CHOWN_ROOT" \( "${prune[@]}" \) -prune -o -exec chown -f www-data:www-data {} +
  else
    chown -Rf www-data:www-data "$CHOWN_ROOT/"
  fi
else
  chown -Rf www-data:www-data "$CHOWN_ROOT/"
fi

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
