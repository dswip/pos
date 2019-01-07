from php:7.2.11-apache-stretch

# enable module 'rewrite'
RUN a2enmod rewrite

# install mysql pdo driver
RUN docker-php-ext-install pdo pdo_mysql

# install mysql mysqli driver
RUN docker-php-ext-install mysqli