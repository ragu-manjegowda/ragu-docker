################################################################################
# Dockerfile to build my container images                                      #
# Based on Ubuntu                                                              #
################################################################################

# Set the base image to Ubuntu 20.04
FROM ubuntu:focal

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
  curl \
  git \
  git-lfs \
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

########################## WEB CRAWLER #########################################

# Update the repository sources list
RUN apt-get update

# Install Dependencies
RUN apt-get install -y \
  python-bs4 \
  python-lxml \
  sqlite3

# Install pip
RUN apt-get install -y python3-pip

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

#################################### R #########################################

################################## PKGDOWN #####################################

# Update the repository sources list
RUN apt-get update -y && apt-get upgrade -y

# Install R packages
RUN apt-get install -y \
  r-cran-littler pandoc \
  libxml2-dev libssl-dev \
  libcurl4-openssl-dev \
  libfontconfig1-dev \
  libharfbuzz-dev \
  libfribidi-dev \
  libfreetype6-dev \
  libpng-dev \
  libtiff5-dev \
  libjpeg-dev

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

# Install release version PKGDOWN from CRAN
RUN R -e 'install.packages("pkgdown", repo="http://cran.us.r-project.org")'

# Install release version DEVTOOLS from CRAN
RUN R -e 'install.packages("devtools", repos="http://cran.us.r-project.org")'

# Install development version from GitHub
RUN R -e 'devtools::install_github("r-lib/pkgdown")'

################################## PAGEDOWN #####################################

# Install release version of remotes from CRAN
RUN R -e 'install.packages("remotes", repos="http://cran.us.r-project.org")'

# Install release version of pagedown from Github
RUN R -e 'remotes::install_github("rstudio/pagedown")'

################ Sensor Fusion Project specific packages #######################

# Update the repository sources list
RUN apt-get update -y && apt-get upgrade -y

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

############################## INSTALL BROWSER #################################

# Update the repository sources list
RUN apt-get update -y && apt-get upgrade -y

# Install Google Chrome browser
RUN apt-get install -y libxss1 libappindicator1 libindicator7

# Download Google Chrome Debian
RUN wget \
  https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb

# Install Google Chrome
RUN apt install -y ./google-chrome*.deb && \
  rm ./google-chrome*.deb

# Delete packages cache
RUN rm -rf /var/lib/apt/lists/*

# Export BROWSER variable
ENV BROWSER /usr/bin/google-chrome

############################### INSTALL RUBY ###################################

# Install asdf
RUN git clone https://github.com/asdf-vm/asdf.git /opt/asdf

ENV ASDF_DATA_DIR /opt/asdf

RUN source /opt/asdf/asdf.sh && \
  source /opt/asdf/completions/asdf.bash && \
  asdf plugin add ruby && \
  asdf install ruby 2.6.2 && \
  asdf global ruby 2.6.2

ENV PATH="/opt/asdf/installs/ruby/2.6.2/bin:${PATH}"

################################ INSTALL RUST ##################################

# Install Rust
ENV RUSTUP_HOME=/opt/rust
ENV CARGO_HOME=/opt/cargo
ENV PATH=/opt/cargo/bin:/opt/rust/bin:$PATH

RUN echo "(curl https://sh.rustup.rs -sSf | \
  sh -s -- -y --default-toolchain stable --no-modify-path) && \
  rustup default stable" > /opt/update-rust.sh && \
  chmod 757 /opt/update-rust.sh

RUN /opt/update-rust.sh

RUN find /opt/cargo -type d -exec chmod 757 {} \;
RUN find /opt/rust -type d -exec chmod 757 {} \;
ENV PATH="/opt/cargo/bin:${PATH}"

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
           cp -u /home/dev/.git* $HOME 2>/dev/null || : && \
           source /opt/asdf/asdf.sh || : && \
           source /opt/asdf/completions/asdf.bash || : && \
           asdf global ruby 2.6.2 || : && \
           echo "ruby version is $(ruby --version)" || : && \
           source /opt/cargo/env && /bin/bash
