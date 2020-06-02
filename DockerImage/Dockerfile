################################################################################
# Dockerfile to build my container images                                      #
# Based on Ubuntu                                                              #
################################################################################

# Set the base image to Ubuntu 18.04
FROM ubuntu:bionic

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
  apt-utils wget ca-certificates \
  apt-transport-https

# Update the repository sources list
RUN apt-get update

# Install basic packages
RUN apt-get install -y \
  --no-install-recommends apt-utils \
  apache2 \
  clang-format-8 \
  cmake \
  git \
  nano \
  ninja-build \
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
  doxygen \
  gdb \
  genisoimage \
  nasm \
  qemu-system-x86

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

########################### R AND PKGDOWN ######################################

# Update the repository sources list
RUN apt-get update -y && apt-get upgrade -y

# Install R packages
RUN apt-get install -y \
  r-cran-littler pandoc \
  libxml2-dev libssl-dev \
  libcurl4-openssl-dev firefox

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

# Install release version PKGDOWN from CRAN
RUN R -e 'install.packages("pkgdown", repo="http://cran.us.r-project.org")'

# Install release version DEVTOOLS from CRAN
RUN R -e 'install.packages("devtools", repos="http://cran.us.r-project.org")'

# Install development version from GitHub
RUN R -e 'devtools::install_github("r-lib/pkgdown")'

# Export BROWSER variable to launch website after build
ENV BROWSER /usr/bin/firefox

################ Sensor Fusion Project specific packages #######################

# Update the repository sources list
RUN apt-get update -y && \
  apt-get upgrade -y

# Install PCL and its dependecies, QT5 and dependecies for openCV
RUN apt-get install -y \
  libavcodec-dev \
  libavformat-dev \
  libopenni2-dev \
  libpcl-dev \
  libproj-dev \
  libswscale-dev \
  mesa-utils \
  pkg-config \
  python3-pip \
  qt5-default

# Install numpy, adding pip (pip2) to maintain compatibility with old projects
RUN pip install --no-cache-dir numpy && pip3 install --no-cache-dir numpy

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

# Install OpenCV
RUN export CURRENT_DIR=$PWD && \
  git clone https://github.com/opencv/opencv.git && \
  git clone https://github.com/opencv/opencv_contrib.git && \
  cd opencv_contrib && git checkout -b 4.3.0 && cd $CURRENT_DIR && \
  cd opencv && git checkout -b 4.3.0 && \
  mkdir build && cd build && \
  cmake \
  -D CMAKE_BUILD_TYPE=Release \
  -D CMAKE_INSTALL_PREFIX=/opt/opencv \
  -D WITH_QT=ON \
  -D WITH_OPENGL=ON \
  -D WITH_GTK=OFF \
  -D OPENCV_EXTRA_MODULES_PATH=../../opencv_contrib/modules \
  -G Ninja .. && \
  ninja install && \
  cd $CURRENT_DIR && rm -rf opencv opencv_contrib

############################## INSTALLATION END ################################

# Create symlink for clang-format
USER root
RUN ln -s /usr/bin/clang-format-8 /usr/bin/clang-format

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

# Copy TMUX config file
COPY configFiles/tmux/.tmux.conf $HOME/

# Set default container command
ENTRYPOINT cp -u /home/dev/.vimrc $HOME 2>/dev/null || : && \
           cp -u /home/dev/.git* $HOME 2>/dev/null || : && /bin/bash
