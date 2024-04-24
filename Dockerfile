FROM php:8.0-apache

# Install dependencies for GD extension
RUN apt-get update && \
    apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Configure GD extension with necessary libraries
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install GD extension
RUN docker-php-ext-install -j$(nproc) gd

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Create necessary directories
RUN mkdir -p /var/www/html/public/images/

# Adjust permissions for directories
RUN chown -R www-data:www-data /var/www/html/public/images/img/ \
    && chmod -R 755 /var/www/html/public/images/img/

# Copy entrypoint script and set it as entrypoint
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# Define volumes
VOLUME /var/www/html
VOLUME /usr/local/etc/php
VOLUME /etc/apache2/sites-available
