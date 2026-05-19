FROM php:8.2-fpm

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY ./src /var/www/html

EXPOSE 9000

CMD ["php-fpm"]