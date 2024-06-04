FROM php:8.3-fpm

COPY . /var/www

WORKDIR /var/www

RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    curl \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libssl-dev

# Install SOAP extension
RUN docker-php-ext-install soap

# Install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN mv .env.example .env

RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]
