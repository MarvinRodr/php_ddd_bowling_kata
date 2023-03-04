FROM php:8.1.6-fpm-alpine
WORKDIR /app

RUN wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.7.9/pickle.phar \
    && mv pickle.phar /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ bash icu-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        zip \
        pdo_mysql

RUN pickle install apcu@5.1.21

ADD ../etc/infrastructure/php/extensions/xdebug.sh /root/install-xdebug.sh
RUN apk add git
RUN sh /root/install-xdebug.sh

RUN docker-php-ext-enable \
        apcu \
        opcache

RUN curl -sS https://get.symfony.com/cli/installer | bash -s - --install-dir /usr/local/bin

COPY ../etc/infrastructure/php /usr/local/etc/php/

# Installing composer to manage packages
RUN php -r "copy('https://composer.github.io/installer.sig', 'installer.sig');" && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php'); unlink('installer.sig');"

# Install node.js
RUN apk add --update nodejs npm

# Install Symfony CLI
RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

# Allow non-root users have home
RUN mkdir -p /opt/home
RUN chmod 777 /opt/home
ENV HOME /opt/home