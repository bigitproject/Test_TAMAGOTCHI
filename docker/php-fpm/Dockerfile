FROM php:7.2.2-fpm
WORKDIR "/application"

RUN apt-get update && \
    apt-get install -y unzip && \
    apt-get install -y libzip-dev && \
    apt-get install -y libpng-dev && \
    apt-get install -y libjpeg-dev && \
    apt-get install -y libfreetype6-dev && \
    apt-get -y install git && \
    apt-get -y install cron && \
    docker-php-ext-install pdo pdo_mysql mbstring zip

RUN docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update && \
    apt-get install -y curl && \
    apt-get install -y gnupg && \
    curl -sL https://deb.nodesource.com/setup_8.x | bash - && \
    apt-get install -y nodejs && \
    apt-get install -y build-essential

COPY ./ /application

RUN php composer.phar update && chmod -R 777 . && php composer.phar dump-autoload

RUN (crontab -l ; echo "* * * * * /usr/local/bin/php /application/artisan schedule:run >>/dev/null 2>&1") | crontab

EXPOSE 9090

CMD service cron start; chmod -R 777 .; php-fpm