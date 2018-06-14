# Ragu's Docker

My docker image with all the necessary dependencies installed for my projects.
Since I work on multiple workstations I am creating a docker image instead of
spending time installing them on all the machines. This also helps me avoid single 
point of failure.

## Instructions

### User instructions

Simply run
```shell
$ docker run -it ragumanjegowda/docker:latest bash
```
or
```shell
$./run.sh
```

### Developer instructions

Modify DockerImage/Dockerfile according to the requirement and run,
```shell
$ ./build.sh
```

Push image to docker hub,
```shell
$ ./push
```
#### You might have to modify build and run scripts according to your needs.
