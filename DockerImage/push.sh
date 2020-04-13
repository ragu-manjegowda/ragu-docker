#!/bin/sh

# Script takes no arguments
if [ $# -ne 0 ]
  then
    echo "argument error, usage: './push.sh' "
    exit 1
fi

dt=$(date '+%Y%m%d%H%M%S');

docker login -u=ragumanjegowda
docker tag testimage:latest ragumanjegowda/docker:latest
docker tag ragumanjegowda/docker:latest ragumanjegowda/docker:$dt

docker push ragumanjegowda/docker:$dt
docker push ragumanjegowda/docker:latest
