#!/bin/bash

# Resolve the docker host's IP address so we can point wp.test at it.
#
# host.docker.internal resolves automatically inside containers on Docker
# Desktop (Mac/Windows), but not on Docker Engine for Linux (e.g. an Ubuntu EC2
# host) unless the compose file maps it via `extra_hosts: host.docker.internal:
# host-gateway`. Where it can't be resolved, fall back to the container's
# default gateway, which is the docker host on a Linux bridge network.

# Parse the default route's gateway from /proc/net/route. The gateway is stored
# little-endian hex, and this needs no iproute2 (`ip`) dependency.
default_gateway() {
  local iface dest gateway rest
  while read -r iface dest gateway rest; do
    [ "$dest" = "00000000" ] || continue
    printf '%d.%d.%d.%d\n' \
      "0x${gateway:6:2}" "0x${gateway:4:2}" "0x${gateway:2:2}" "0x${gateway:0:2}"
    return 0
  done < /proc/net/route
  return 1
}

INTERNAL_IP=$( getent hosts host.docker.internal | awk '{ print $1 }' | head -n1 )

if [ -z "$INTERNAL_IP" ]; then
  INTERNAL_IP=$( default_gateway )
fi

if [ -z "$INTERNAL_IP" ]; then
  echo "FAILED resolving the docker host IP address for wp.test"
  exit 1
fi

if echo "$INTERNAL_IP wp.test" >> /etc/hosts; then
  echo "SUCCESS adding wp.test ($INTERNAL_IP) to container /etc/hosts"
else
  echo "FAILED attempting to add wp.test to container /etc/hosts"
  exit 1
fi
