ARG NODE_VERSION
ARG PHP_VERSION
ARG COMPOSER_VERSION

# Etapa 1: Node.js
FROM node:${NODE_VERSION} AS node-build

# Etapa 2: Composer
FROM composer:${COMPOSER_VERSION} AS composer

# Etapa 3: PHP-FPM + Node
FROM php:${PHP_VERSION}-fpm AS php-fpm


# Copia Node.js + npm 
COPY --from=node-build /usr/local/ /usr/local/

# Dependências
RUN apt update && apt install -y \
    nano \
    sshpass \
    procps \
    acl \
    apt-transport-https \
    build-essential \
    ca-certificates \
    coreutils \
    curl \
    file \
    gettext \
    git \
    wget \
    zip \
    unzip \
    libssl-dev \
    mariadb-client \
    odbcinst \
    libodbc1 \
    zsh \
    iputils-ping \
    tzdata \
    gnupg

# Timezone
ENV TZ=America/Sao_Paulo
RUN echo "date.timezone = America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Oh My Zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" && chsh -s /bin/zsh

# Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# PHP Extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions opcache xdebug oci8 sockets amqp intl pdo pdo_oci soap gd pgsql mysqli odbc pdo_mysql pdo_pgsql pdo_odbc

# Symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash && \
    apt install -y symfony-cli

# Expor porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
