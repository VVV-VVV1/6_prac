# Используем официальный образ PHP с Apache
FROM php:7.4-apache

# Установка зависимостей для Redis и других PHP-расширений
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    git && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    gd \
    zip && \
    pecl install redis && docker-php-ext-enable redis && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Копирование конфигурации сайта в директорию веб-сервера
COPY ./apache/site /var/www/html/

RUN chmod 777 /var/www/html/my-php-api/www


# Убедитесь, что права на файлы правильные
RUN chown -R www-data:www-data /var/www/html/ && \
    chmod -R 777 /var/www/html/

# Убедитесь, что Apache будет работать с правильной кодировкой
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Открытие порта для Apache
EXPOSE 80
