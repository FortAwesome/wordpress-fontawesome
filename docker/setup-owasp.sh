#/bin/bash

set -e -x

OWASP_LATEST_VERSION_TAG=$(\
  curl https://api.github.com/repos/coreruleset/coreruleset/releases \
  | jq 'map(select(.prerelease == false and .draft == false)) | sort_by(.published_at) | reverse | .[0] | .tag_name'\
  | sed 's/\"//g'
  )

curl -L -s https://github.com/coreruleset/coreruleset/archive/${OWASP_LATEST_VERSION_TAG}.tar.gz > /tmp/owasp-coreruleset.tgz

OWASP_ARCHIVE_TOP_LEVEL_DIR=$(tar -tzf /tmp/owasp-coreruleset.tgz | head -1 | cut -d"/" -f1)

tar -zxf /tmp/owasp-coreruleset.tgz

mv  ${OWASP_ARCHIVE_TOP_LEVEL_DIR} coreruleset

mv coreruleset/crs-setup.conf.example coreruleset/crs-setup.conf

mkdir /etc/apache2/modsecurity-crs

mv coreruleset/ /etc/apache2/modsecurity-crs/coreruleset
