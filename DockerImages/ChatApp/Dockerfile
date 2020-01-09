FROM php:7.4
RUN docker-php-ext-install pdo pdo_mysql bcmath sockets
WORKDIR /app

CMD ["php","/app/ratchet/chat-server.php"]





