FROM php:8.2.15-fpm

ARG UID
EXPOSE $UID

# Create user and some useful stuff
RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/
RUN echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config
RUN echo "export COLUMNS=300" >> /home/appuser/.bashrc
RUN echo "alias sf=/appdata/www/bin/console" >> /home/appuser/.bashrc

# Install packages and PHP extensions
RUN apt update \
    && apt install -y git acl openssl openssh-client wget zip vim libssh-dev \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Install RabbitMQ and XDEBUG
RUN apt install -y librabbitmq-dev \
    && pecl install amqp xdebug \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache amqp xdebug

# Install and update Composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

# Install PHP-CS-FIXER
RUN wget https://cs.symfony.com/download/php-cs-fixer-v3.phar -O php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

# Install Symfony Binary
USER appuser
RUN wget https://get.symfony.com/cli/installer -O - | bash
USER root

RUN mkdir -p /appdata/www

# Config XDEBUG
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /appdata/www
