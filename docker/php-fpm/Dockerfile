FROM php:7.4.11-fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it
RUN chmod o+r /etc/resolv.conf
RUN echo "nameserver 185.51.200.2" >> /etc/resolv.conf
RUN echo "nameserver 178.22.122.100" >> /etc/resolv.conf
#RUN whereis ping
#RUN cat /etc/resolv.conf
RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*
#RUN ping -t 10 ftp.halifax.rwth-aachen.de
RUN echo -e "http://ftp.halifax.rwth-aachen.de/alpine/latest-stable/main/\nhttps://ftp.halifax.rwth-aachen.de/alpine/latest-stable/community/" >> /etc/apk/repositories
RUN echo -e "http://uk.alpinelinux.org/alpine/latest-stable/main/\nhttp://uk.alpinelinux.org/alpine/latest-stable/community/" >> /etc/apk/repositories
RUN apk update --no-cache --wait 10
RUN apk upgrade 

RUN apk add --no-cache --wait 10 \
    git \
    g++ \
    bash \
    libzip-dev \
    zip \
    vim \
    $PHPIZE_DEPS \
    openssl-dev

RUN docker-php-ext-install \
    zip \
    pdo_mysql

RUN pecl install \
    apcu \
    xdebug \
    redis

RUN docker-php-ext-enable \
    zip \
    #xdebug \
    pdo_mysql

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#retun composer to version one
RUN composer self-update --1


#install Symfony cli
RUN curl -sS https://get.symfony.com/cli/installer |bash
ENV PATH="/root/.symfony/bin:${PATH}"

WORKDIR /var/www

CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm 

EXPOSE 9000
