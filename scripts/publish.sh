#!/usr/bin/env bash
#

if [[ -f "./bin/wstools.phar" ]]; then
  unlink ./bin/wstools
  mv ./bin/wstools.phar ./bin/wstools
  chown root:root ./bin/wstools
  chmod +x ./bin/wstools
  echo "wstools executable published"
else
  echo "no phar available"
fi