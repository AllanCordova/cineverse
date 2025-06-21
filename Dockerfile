# Dockerfile

# 1) Base oficial com PHP 8.1 + Apache
FROM php:8.1-apache

# 2) Instala extensões necessárias
RUN apt-get update \
 && apt-get install -y --no-install-recommends libzip-dev libpng-dev libonig-dev \
 && docker-php-ext-install mysqli pdo_mysql mbstring zip gd \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*


# 3) Habilita mod_rewrite
RUN a2enmod rewrite

# 4) Ajusta DocumentRoot (caso use public/; senão remova esta parte)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!<Directory /var/www/html>!<Directory ${APACHE_DOCUMENT_ROOT}>!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5) Copia código e ajusta permissões
WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data /var/www/html

# 6) Exponha porta 80 e inicie o Apache
EXPOSE 80
CMD ["apache2-foreground"]
