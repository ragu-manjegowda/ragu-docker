[![Docker Image CI](https://github.com/ragu-manjegowda/ragu-docker/workflows/Docker%20Image%20CI/badge.svg)](https://github.com/ragu-manjegowda/ragu-docker/actions)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

# Ragu's Docker Image

My docker image with all the necessary dependencies installed for my projects.
Since I work on multiple workstations I am creating a docker image instead of
spending time installing them on all the machines. This also helps me avoid single 
point of failure.

## Instructions

### User instructions

#### Simply run
```shell
$ docker run -it ragumanjegowda/docker:latest bash
```

#### or
```shell
$./run.sh
```

### Developer instructions

#### To build locally,
```shell
$ ./build.sh
```

#### To push image to docker hub,
```shell
$ ./push
```

#### You might have to modify build and run scripts according to your needs.

