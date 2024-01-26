FROM php:8.2-fpm
WORKDIR /usr/src/app

# Variables to configure user and permissions
ARG WWWUSER=www
ARG WWWGROUP=www
ARG UID
ARG GID

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Add user for laravel application
RUN groupadd -g ${GID} ${WWWGROUP}
RUN useradd -u ${UID} -ms /bin/bash -g ${WWWGROUP} ${WWWUSER}

RUN chown -Rvc ${WWWUSER}:${WWWGROUP} /usr/src/app


USER ${WWWUSER}

EXPOSE 9000

CMD ["php-fpm"]
