DOCKER_COMPOSE=`which docker-compose`
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
DEFAULT_CONTAINER_NAME=com.fontawesome.wordpress-latest-dev

if [ ! -x "$DOCKER_COMPOSE" ]; then
  echo "ERROR: docker-compose not found. Make sure it's installed and available in your PATH."
  exit 1
fi

DOCKER=`which docker`

if [ ! -x "$DOCKER" ]; then
  echo "ERROR: docker not found. Make sure it's installed and available in your PATH."
  exit 1
fi

WP_CONTAINER=$DEFAULT_CONTAINER_NAME

if [ "-c" == "$1" ]; then
  while getopts ":c:" opt; do
    case ${opt} in
      c )
        WP_CONTAINER=${OPTARG}
        ;;
      \? )
        echo "Invalid Option: -$OPTARG" 1>&2
        exit 1
        ;;
    esac
  done

  shift $((OPTIND -1))
fi

echo "Using container: $WP_CONTAINER"
