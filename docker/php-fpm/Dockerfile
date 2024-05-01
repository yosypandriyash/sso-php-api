FROM php:8.2-fpm-bullseye

RUN apt-get update && apt-get install -y \
    apt-utils \
    curl \
    g++ \
    git \
    gnupg2 \
    libicu-dev \
    libssl-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    zlib1g-dev

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    gmp \
    intl \
    gd \
    mysqli \
    pdo_mysql \
    pdo \
    zip \
    yaml

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN export PATH=$PATH":/usr/bin"