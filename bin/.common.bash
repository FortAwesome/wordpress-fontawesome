get_wp_container_id() {
  DOCKER=`which docker`

  if [ ! -x "$DOCKER" ]; then
    echo "ERROR: docker not found. Make sure it's installed and available in your PATH."
    exit 1
  fi

  WP_CONTAINER_ID=`$DOCKER ps --filter "name=com.fontawesome.wordpress" --filter "status=running" -q -l`

  if [ "$WP_CONTAINER_ID" == "" ]; then
    echo "ERROR: the Font Awesome WordPress container does not appear to be running. Did you run 'docker-compose up'?"
    exit 1
  fi
}
