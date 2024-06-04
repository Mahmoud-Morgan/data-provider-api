# Use the official PHP 8.1 image as base
FROM php:8.2

# Set the working directory inside the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files to the working directory
COPY . .

# Install PHP extensions if needed (example: pdo_mysql, gd, etc.)
# RUN docker-php-ext-install pdo_mysql

# Expose port if needed (example: 8000 for PHP built-in server)
# EXPOSE 8000

# Command to run your PHP application
# CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

