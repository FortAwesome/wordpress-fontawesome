#!/bin/bash

INTERNAL_IP=$( php -r 'print gethostbyname("host.docker.internal");' )

if [ "xhost.docker.internal" == x${INTERNAL_IP} ]; then
	echo "FAILED resolving host.docker.internal in the docker container"
	exit 1
fi

echo "$INTERNAL_IP fa.test" >> /etc/hosts

if [ "$?" == "0" ]; then
  echo "SUCCESS adding fa.test to container /etc/hosts"
else
  echo "FAILED attempting to add fa.test to container /etc/hosts"
  exit 1
fi
