FROM php:7.3-apache
MAINTAINER tomas@devhouse.lt
RUN dpkg-reconfigure --frontend noninteractive tzdata

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    wget nano mariadb-client libmcrypt-dev zlib1g-dev libxslt1.1 libzip-dev libfreetype6-dev libxml2-dev libjpeg62-turbo-dev libpng-dev libxslt1-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) mbstring mysqli pdo_mysql zip exif soap xsl gd \
    && pecl install mcrypt-1.0.3 &&  docker-php-ext-enable mcrypt \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /root/*

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod ssl
RUN a2enmod rewrite
RUN a2enmod headers

RUN rm /etc/apache2/sites-enabled/000-default.conf

COPY vhosts.conf /etc/apache2/sites-available/
COPY php/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

COPY cert/localhost.crt /etc/apache2/cert/
COPY cert/localhost.key /etc/apache2/cert/

RUN a2ensite vhosts

RUN pecl install xdebug

COPY php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
