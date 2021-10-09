FROM php:7.4-fpm-alpine3.13

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=symfonycorp/cli /symfony /usr/bin/symfony

# Creating docker user
RUN addgroup -g 1000 docker && \
    adduser -u 1000 -G docker -h /home/docker -s /bin/sh -D docker

# Installing fixuid (https://github.com/boxboat/fixuid)
RUN USER=docker && \
    GROUP=docker && \
    curl -SsL https://github.com/boxboat/fixuid/releases/download/v0.5/fixuid-0.5-linux-amd64.tar.gz | tar -C /usr/local/bin -xzf - && \
    chown root:root /usr/local/bin/fixuid && \
    chmod 4755 /usr/local/bin/fixuid && \
    mkdir -p /etc/fixuid && \
    printf "user: $USER\ngroup: $GROUP\n" > /etc/fixuid/config.yml

# Install waitforit (https://github.com/maxcnunes/waitforit)
RUN \
    wget -O /usr/local/bin/waitforit https://github.com/maxcnunes/waitforit/releases/download/v2.4.1/waitforit-linux_amd64 && \
    chmod +x /usr/local/bin/waitforit

# Install make
RUN apk add --no-cache make

# Install php extensions
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

RUN apk add --no-cache --virtual .persistent-deps \
    # for amqp
        libressl-dev

# Install amqp
RUN apk add --no-cache --no-progress --virtual .build_deps_php_amqp rabbitmq-c-dev \
    && apk add --no-cache --no-progress rabbitmq-c \
    && apk add --no-cache git autoconf automake gawk build-base \
    && pecl install amqp \
    && apk del .build_deps_php_amqp

# Copy configuration
COPY config/amqp.ini /usr/local/etc/php/conf.d/

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=idekey" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=127.0.0.1:8000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

USER docker:docker

EXPOSE 8000
WORKDIR /app
ENTRYPOINT ["fixuid", "-q"]
CMD ["symfony", "server:start", "--port=8000"]
