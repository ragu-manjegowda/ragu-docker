############################################################
# Dockerfile to build my container images
# Based on Ubuntu
############################################################

# Set the base image to Ubuntu
FROM ubuntu:xenial

# File Author / Maintainer
MAINTAINER Raghavendra Manjegowda <raghavendrahm0410@gmail.com>

# Set default shell to bash
RUN ln -sf /bin/bash /bin/sh

# Disable build warnings
ARG DEBIAN_FRONTEND=noninteractive

# Disable apt-utils warning
RUN apt-get update -qqy \
  && apt-get -qqy install \
  wget ca-certificates apt-transport-https

# Update the repository sources list
RUN apt-get update

# Install basic pacakges
RUN apt-get install -y \
  --no-install-recommends apt-utils \
  nano \
  sudo \
  vim \
  wget

# SET ENV
ENV HOME /home

########################## BEGIN INSTALLATION #################################

################## WEB CRAWLER ######################

# Update the repository sources list
RUN apt-get update

# Install Dependencies
RUN apt-get install -y \
  python-bs4 \
  python-lxml \
  sqlite3

# Install pip
RUN wget https://bootstrap.pypa.io/get-pip.py --no-check-certificate && \
  chmod +x get-pip.py && \
  python get-pip.py && \
  rm get-pip.py

# Install dependencies
RUN pip install wikipedia \
  pyopenssl ndg-httpsclient pyasn1

# Update the repository sources list once more
RUN apt-get update

############################## INSTALLATION END ##############################

# Set working directory
WORKDIR "/home"

# Set default container command
ENTRYPOINT /bin/bash
CMD ["ls"]
