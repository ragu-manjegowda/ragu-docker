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

# Install basic packages
RUN apt-get install -y \
  --no-install-recommends apt-utils \
  nano \
  sudo \
  vim \
  cmake \
  tmux \
  wget

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

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

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

################## LITTLE OS ######################

# Update the repository sources list
RUN apt-get update

# Install Basic packages
RUN apt-get install -y \
  build-essential \
  nasm \
  genisoimage \
  bochs \
  bochs-sdl

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

############################## INSTALLATION END ##############################

# Copy VIM config file
COPY configFiles/.vimrc $HOME/.vimrc

# Set working directory
WORKDIR "/home"

# Set default container command
ENTRYPOINT /bin/bash
CMD ["ls"]
