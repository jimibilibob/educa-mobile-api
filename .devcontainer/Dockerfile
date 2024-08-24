FROM php:8.1.27-fpm

ARG USERNAME
ENV USERNAME=$USERNAME

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
    sudo \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    zip \
    unzip \
    build-essential \
    libaio1 \
    libzip-dev \
    git \
    wget \
    openssh-client\
    zsh \
    libldap2-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && rm /var/log/lastlog /var/log/faillog

RUN pecl install redis
RUN echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath calendar pgsql pdo_pgsql;
RUN docker-php-ext-install gd zip

RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN groupadd -g 1000 $USERNAME
RUN useradd -d /home/$USERNAME -s /bin/bash -u 1000 -g 1000 $USERNAME
RUN adduser $USERNAME sudo
RUN mkdir /home/$USERNAME
RUN chown -R $USERNAME:$USERNAME /home/$USERNAME
RUN echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
USER $USERNAME

WORKDIR /api

# ENV COMPOSER_ALLOW_SUPERUSER=1
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)"

COPY . .

RUN sudo chown -R $USERNAME:$USERNAME .
RUN composer install --no-interaction --ignore-platform-reqs

CMD php artisan serve --host 0.0.0.0

