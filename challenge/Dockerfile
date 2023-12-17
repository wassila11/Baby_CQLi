# Use the official PHP with Apache base image
FROM php:7.4-apache

# Install SQLite3 extension
RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo_sqlite

# Enable Apache modules
RUN a2enmod rewrite

# Copy flag
COPY .secret /

# Set permissions for the database file
COPY challenge/views/sql/minions.db /var/www/html/sql/minions.db
RUN chown www-data:www-data /var/www/html/sql/minions.db \
    && chmod 664 /var/www/html/sql/minions.db

# Set permissions for the sql directory
RUN chown -R www-data:www-data /var/www/html/sql \
    && chmod 775 /var/www/html/sql

# Set permissions for the web root directory
RUN chown -R www-data:www-data /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
