FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpng-dev libzip-dev libpq-dev zip unzip git \
    curl gnupg && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql pdo_pgsql gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

CMD php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan migrate --force && apache2-foreground

EXPOSE 80