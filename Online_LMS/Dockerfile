FROM php:8.2-apache

# Installer les extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier les fichiers
COPY . /var/www/html/

# Configurer Apache
RUN chown -R www-data:www-data /var/www/html/
RUN a2enmod rewrite

# Exposer le port
EXPOSE 80
