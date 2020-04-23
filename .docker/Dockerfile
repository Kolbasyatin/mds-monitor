FROM php:7.4-cli as dev

WORKDIR /usr/src/app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions intl opcache xdebug sockets zip

RUN apt update && apt install -y wget git fish sudo

RUN curl --silent --show-error https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY .docker/xdebug-settings.ini "$PHP_INI_DIR/conf.d/xdebug-settings.ini"

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN useradd -s /usr/bin/fish -m zalex && echo 'zalex:zalex' | chpasswd && usermod -a -G sudo zalex
COPY . /usr/src/app
RUN chown -R zalex:zalex .
USER zalex

CMD ["php", "-v"]

FROM  dev as prod
USER root
RUN rm -rf ./* \
    && rm "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini" \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && mkdir -p /tmp/swiftmailer/spool && chmod -R 777 /tmp/swiftmailer/spool
COPY . /usr/src/app

ENV APP_ENV=prod \
    APP_MPD_CLIENT_HOST=localhost \
    APP_MPD_CLIENT_PORT=6600 \
    APP_MPD_CLIENT_PASSWORD='' \
    APP_EMAIL_RECEIVER='notify@planeset.ru'

RUN  composer install --no-dev --optimize-autoloader
RUN chown zalex:zalex .
USER zalex
CMD ["fish"]