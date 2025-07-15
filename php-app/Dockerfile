# Use official PHP image as base.
FROM php:8.5.0alpha1-apache

# Install mysqli and redis extensions.
RUN docker-php-ext-install mysqli \
    && apt update && apt install -y libzip-dev \
    && rm -rf /var/lib/opt/lists/*

# Install Redis PHP extensions
RUN pecl install redis \
    && docker-php-ext-enable redis

# Copy the application code into Apache web root
COPY index.php /var/www/html
COPY .env /var/www/html/

# Expose port
EXPOSE 80