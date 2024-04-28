FROM php:8.2-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libpq-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip xml iconv simplexml dom

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y nodejs npm

RUN  npm install -g pnpm



RUN addgroup --gid 1000 laravel
RUN adduser --ingroup laravel --shell /bin/sh laravel
USER laravel


EXPOSE 9000
EXPOSE 3000
CMD ["php-fpm"]
