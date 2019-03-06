# OS
FROM amazonlinux:2018.03

# Owner
LABEL key="Helio Nogueira <helio.nogueir@gmail.com>"

# TIMEZONE
RUN echo "ZONE=\"America/Sao_Paulo\"" | tee --append /etc/sysconfig/clock
RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

# /root/.bashrc
RUN echo "alias ll=\"ls -alh --color\"" | tee --append /root/.bashrc;

# Update and Upgrade
RUN yum -y update && yum -y upgrade

# Install MySQL
RUN yum install -y mysql

# Install Nginx Server
RUN yum install -y nginx
RUN echo "NETWORKING=yes" > /etc/sysconfig/network

# Install PHP 7.0
RUN yum install -y \
    php72-opcache \
    php72-gd \
    php72-intl \
    php72-json \
    php72-mbstring \
    php72-pecl-mcrypt \
    php72-mysqlnd \
    php72-pdo \
    php72-xml \
    php72-xmlrpc \
    php72-pecl-igbinary \
    php72-pecl-imagick \
    php72-pecl-uuid \
    php72-bcmath \
    php72-process \
    php72-cli \
    php72-fpm \
    php72

# Install Composer
RUN php -r "copy(\"https://getcomposer.org/installer\", \"composer-setup.php\");";
RUN php "composer-setup.php";
RUN php -r "unlink(\"composer-setup.php\");";
RUN mv "composer.phar" "/usr/bin/composer";

# Clean Install
RUN yum clean all

# Workspace
WORKDIR /var/www/app

# Start Application
ENTRYPOINT [ "/root/docker-entrypoint.sh" ]