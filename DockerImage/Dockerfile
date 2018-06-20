################################################################################
# Dockerfile to build my container images                                      #
# Based on Ubuntu                                                              #
################################################################################

# Set the base image to Ubuntu
FROM ubuntu:xenial

# File Author / Maintainer
MAINTAINER Raghavendra Manjegowda <raghavendrahm0410@gmail.com>

# Set default shell to bash
RUN ln -sf /bin/bash /bin/sh

# Create a development user
RUN useradd -ms /bin/bash dev && \
  echo "dev:dev" | chpasswd && \
  adduser dev sudo

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
  apache2 \
  cmake \
  git \
  nano \
  sudo \
  tmux \
  tree \
  vim \
  wget

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

########################## BEGIN INSTALLATION ##################################

########################## Configure Website ###################################

# Copy index and favicon to Apache2 folder
COPY configFiles/apache2/* /var/www/html/

########################## WEB CRAWLER #########################################

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

########################## LITTLE OS ###########################################

# Update the repository sources list
RUN apt-get update -y && apt-get upgrade -y

# Install Basic packages
RUN apt-get install -y \
  bochs \
  bochs-sdl \
  build-essential \
  gdb \
  genisoimage \
  nasm \
  qemu-system-x86

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

############################## INSTALLATION END ################################

# Restart Apache2
CMD systemctl restart apache2

# Set default user
USER dev

# SET ENV
ENV HOME /home/dev

# Set working directory
WORKDIR $HOME

# Copy VIM config file
COPY configFiles/vim/.vimrc $HOME/.vimrc

# Copy GIT config file
COPY configFiles/git/.git* $HOME/

# Set default container command
ENTRYPOINT echo =============== Change dir to $HOME ================ && \
  cp -u /home/dev/.vimrc $HOME 2>/dev/null || : && cp -u /home/dev/.git* $HOME 2>/dev/null || : && /bin/bash
