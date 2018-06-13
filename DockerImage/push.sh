#!/bin/sh

#Check the arguments to configure openvpn as client or server
if [ $# -ne 0 ]
  then
    echo "argument error, usage: './push.sh' "
    exit 1
fi

dt=$(date '+%Y%m%d');

docker login -u=ragumanjegowda
docker tag baseimage:latest ragumanjegowda/docker:latest
docker tag raag079/docker:latest ragumanjegowda/docker:$dt

docker push ragumanjegowda/docker:$dt
docker push ragumanjegowda/docker:latest
