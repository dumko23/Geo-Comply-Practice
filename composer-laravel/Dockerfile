FROM php:7.4-fpm

COPY local.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
            curl \
            wget \
            git \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
    	libpng-dev \
    	libonig-dev \
    	libzip-dev \
    	libmcrypt-dev \
            && pecl install mcrypt \
    	&& docker-php-ext-enable mcrypt \
            && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
            && docker-php-ext-install -j$(nproc) gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY /script/script.sh /var/www

WORKDIR /var/www

RUN ["/bin/bash", "./script.sh"]

CMD ["php-fpm"]