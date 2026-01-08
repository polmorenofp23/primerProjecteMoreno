FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite si usas URLs amigables o .htaccess
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar todo el código del proyecto al docroot de Apache
COPY . .

# Opcional: si tienes un directorio público distinto (por ejemplo ./public),
# podríamos cambiar esto a:
# WORKDIR /var/www/html
# COPY public/ ./