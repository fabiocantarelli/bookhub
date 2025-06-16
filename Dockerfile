# Etapa 1: Node.js
FROM node:22.16.0 AS node

# Etapa 2: Composer
FROM composer:latest AS composer

# Etapa 3: PHP-FPM + Node
FROM php:8.4-fpm AS php-fpm

# Copia Node.js + npm 
COPY --from=node /usr/local/ /usr/local/

# Dependências
RUN apt update && apt install -y \
    procps \
    acl \
    apt-transport-https \
    build-essential \
    ca-certificates \
    coreutils \
    curl \
    file \
    gettext \
    wget \
    zip \
    unzip \
    libssl-dev \
    mariadb-client \
    odbcinst \
    libodbc1 \
    iputils-ping \
    tzdata \
    gnupg \
    wkhtmltopdf


# Timezone
ENV TZ=America/Sao_Paulo
RUN echo "date.timezone = America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions opcache xdebug sockets intl pdo gd pgsql mysqli odbc pdo_mysql

# Expor porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
