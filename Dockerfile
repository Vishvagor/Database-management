# Dockerfile

# Use the official PHP image with Apache installed
FROM php:8.1-apache

# Install the MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the PHP source code from the src folder to the Apache document root
COPY ./src/ /var/www/html/

# Expose port 80 for the web server
EXPOSE 80
