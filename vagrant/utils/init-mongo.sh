#!/usr/bin/env bash
#
DIR="$( cd "$( dirname "$0" )" && pwd )"
dbName=${1:-''}

if [[ -z "$1" ]]
then
  echo "Missing argument dbName"
  exit
fi


# Create root user and daily user
# (mongo prompt understands javascript)
mongo --eval "let dbName = \"$dbName\";" "$DIR/create-users.js"

# Set up authentication
#
sed -i.bak "s/^#security:/security:\\n  authorization: enabled/" /etc/mongod.conf

service mongod restart