FROM php:8.2-fpm

LABEL Name=portfolio_php_fpm_${PHP_VERSION} \
    Version=0.0.1 \
    Maintainer="Weda Dewa <weda.dewa@yahoo.co.id>" \
    Description="Image PHP developer on Debian Linux."

ARG PHP_VERSION=8.2

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
  curl \
  gnupg2 \
  ca-certificates \
  software-properties-common

# Install PHP only if PHP_VERSION is specified
RUN if [ -n "$PHP_VERSION" ]; then \
        add-apt-repository ppa:ondrej/php && \
        apt-get update && \
        apt-get install -y \
            php${PHP_VERSION} \
            php${PHP_VERSION}-cli \
            php${PHP_VERSION}-common \
            php${PHP_VERSION}-json \
            php${PHP_VERSION}-opcache \
            php${PHP_VERSION}-mysql \
            php${PHP_VERSION}-mbstring \
            php${PHP_VERSION}-zip \
            php${PHP_VERSION}-fpm \
            php${PHP_VERSION}-curl \
            php${PHP_VERSION}-dom \
            php${PHP_VERSION}-pgsql \
            php${PHP_VERSION}-gd \
            libzip-dev; \
        alias php='php${PHP_VERSION}' && \
        alias php-fpm='php${PHP_VERSION}-fpm' && \
        alias artisan='php artisan'; \
    fi

# Install packages specific to PostgreSQL or MySQL based on the DATABASE_DRIVER argument
RUN apt-get install -y postgresql libpq-dev
RUN docker-php-ext-install pgsql pdo_pgsql 

# Install Composer with the specified version
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 

# Extension
RUN apt-get -y install libonig-dev libzip-dev

RUN rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip

# Set the working directory
WORKDIR /var/www/html

# Copy your application code to the container
COPY . .

RUN composer install --no-scripts --no-autoloader --no-dev --ignore-platform-reqs

# Expose any necessary ports
EXPOSE 9000

# Run any necessary commands
CMD ["php-fpm", "-F"]
