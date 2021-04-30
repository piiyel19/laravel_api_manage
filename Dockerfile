FROM alpine

# ENV \
#   APP_DIR="php /var/www/html/php_project/appku/" \
#   APP_PORT="8082"

# # the "app" directory (relative to Dockerfile) containers your Laravel app...
# COPY app/ $APP_DIR

# RUN apk add --update \
#     curl \
#     php \
#     php-opcache \
#     php-openssl \
#     php-pdo \
#     php-json \
#     php-phar \
#     php-dom \
#     && rm -rf /var/cache/apk/*

# RUN curl -sS https://getcomposer.org/installer | php -- \
#   --install-dir=/usr/bin --filename=composer

# RUN cd $APP_DIR && composer install

# WORKDIR $APP_DIR
#CMD php /var/www/html/php_project/appku/ artisan serve --host=0.0.0.0 --port=8082


# FROM php:7.4
# COPY . /var/www/html/php_project/appku/
# WORKDIR /var/www/html/php_project/appku/
# CMD [ "php", "artisan serve --host=0.0.0.0 --port=8082" ]