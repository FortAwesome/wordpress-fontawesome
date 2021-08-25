EXPORTS_REL_DIR=exports
IMPORTS_REL_DIR=imports
UPLOADS_REL_DIR=uploads
CONTAINER_EXPORTS_DIR=/var/www/html/${EXPORTS_REL_DIR}
CONTAINER_IMPORTS_DIR=/var/www/html/${IMPORTS_REL_DIR}
HOST_WP_DIR=$DIR/../volumes/wordpress
HOST_EXPORTS_DIR=$HOST_WP_DIR/$EXPORTS_REL_DIR
HOST_IMPORTS_DIR=$HOST_WP_DIR/$IMPORTS_REL_DIR
HOST_UPLOADS_DIR=$HOST_WP_DIR/wp-content/$UPLOADS_REL_DIR
SEEDS_DIR=$DIR/../seeds
WP_CLI_CACHE_DIR=/tmp/.wp-cli/cache

DOCKER=`which docker`

if [ ! -x "$DOCKER" ]; then
  echo "ERROR: docker not found. Make sure it's installed and available in your PATH."
  exit 1
fi
