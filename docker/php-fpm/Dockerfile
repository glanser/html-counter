FROM php:8.1-fpm

RUN apt-get update; \
    apt-get install -y git zip unzip

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer

RUN groupmod -o -g 1000 www-data; \
    usermod -o -u 1000 -g www-data www-data;

WORKDIR /var/www/html

CMD ["php-fpm"]

EXPOSE 9000