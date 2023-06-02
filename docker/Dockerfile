FROM php:8.1-fpm-alpine

RUN apk update && apk add bash

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Creating docker user
RUN addgroup -g 1000 docker && \
    adduser -u 1000 -G docker -h /home/docker -s /bin/sh -D docker

# intall symfony cli
USER docker:docker
RUN curl -sS https://get.symfony.com/cli/installer | bash

USER root:root

# Install waitforit (https://github.com/maxcnunes/waitforit)
RUN \
    wget -O /usr/local/bin/waitforit https://github.com/maxcnunes/waitforit/releases/download/v2.4.1/waitforit-linux_amd64 && \
    chmod +x /usr/local/bin/waitforit

# Install make
RUN apk add --no-cache make

RUN apk add libxml2-dev

# Install php extensions
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install -j$(nproc) pdo_pgsql xml

#install amqp and rmq
RUN apk --update --no-cache add build-base \
        autoconf \
        rabbitmq-c-dev
RUN pecl install amqp
RUN docker-php-ext-enable amqp

# Copy configuration
COPY config/amqp.ini /usr/local/etc/php/conf.d/

USER docker:docker

EXPOSE 8000
WORKDIR /app
CMD ["/home/docker/.symfony5/bin/symfony", "server:start", "--port=8000"]
