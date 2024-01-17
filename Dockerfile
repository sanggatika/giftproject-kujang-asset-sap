# Use the official PHP 8.2 FPM base image
FROM php:8.2-fpm

# Set the timezone to Asia/Jakarta
ENV TZ="Asia/Jakarta"

# Copy semua project directory
COPY composer.* /var/www/starterkit-laravel-metronic/

# Working Directory Server
WORKDIR /var/www/starterkit-laravel-metronic

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql 
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Premision Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . .

# Copy existing application directory permissions
COPY --chown=www:www . .

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# Menjalankan Service php-fpm
CMD ["php-fpm"]
