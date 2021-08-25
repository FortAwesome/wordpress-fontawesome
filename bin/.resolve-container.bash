DEFAULT_CONTAINER_NAME=com.fontawesome.wordpress-latest-dev

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
