DOCKER_COMPOSE=`which docker-compose`

if [ ! -x "$DOCKER_COMPOSE" ]; then
  echo "ERROR: docker-compose not found. Make sure it's installed and available in your PATH."
  exit 1
fi

DOCKER=`which docker`

if [ ! -x "$DOCKER" ]; then
  echo "ERROR: docker not found. Make sure it's installed and available in your PATH."
  exit 1
fi

if [ "-c" != "$1" ]; then
  echo "USAGE: $0 -c <container name or ID> [other args]"
  echo
  echo "  Runs command in a running WordPress container."
  echo "  Make sure you've started one up with bin/dev or bin/integration"
  echo "  Here's what seems to be running so far:"
  echo
  printf "ID\t\tName\n"
  $DOCKER ps --filter "name=com.fontawesome.wordpress*" --filter "status=running" --format "{{.ID}}\t{{.Names}}"
  exit 1
fi

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

if [ "x" = "${WP_CONTAINER}x" ]; then
	echo "Sorry, we still don't know which container you intend"
	exit 1
fi

