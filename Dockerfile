# Dockerfile для PHP-приложения

FROM php:7.4-fpm

# Установите необходимые пакеты
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libgd-dev

# Устанавливаем расширение Redis
RUN pecl install redis && docker-php-ext-enable redis

# Копируем код приложения
COPY . /var/www/html/

# Настроим рабочую директорию
WORKDIR /var/www/html

RUN chmod -R 777 /var/www/html/my-php-api/www

# Скопировать файлы pChart в контейнер
COPY ./src/pchart /var/www/html/src/pchart


# Откроем порт для PHP-FPM
EXPOSE 9000

# Запустим PHP-FPM
CMD ["php-fpm"]

