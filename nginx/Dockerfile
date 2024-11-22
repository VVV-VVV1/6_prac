# Используем официальный образ Nginx
FROM nginx:alpine

# Копирование конфигурации для Nginx
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Копирование статических файлов в директорию Nginx
COPY ./nginx/static/ /usr/share/nginx/html/static/

# Открытие порта для Nginx
EXPOSE 80
