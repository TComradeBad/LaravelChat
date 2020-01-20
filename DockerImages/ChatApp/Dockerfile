FROM php:7.4
RUN docker-php-ext-install pdo pdo_mysql bcmath sockets
RUN apt-get update && apt-get install -y libz-dev libmemcached-dev
RUN pecl install memcached
WORKDIR /app
CMD ["php","artisan","serve","--host","0.0.0.0"]





