FROM php:7.4-cli as dev

WORKDIR /usr/src/app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions intl opcache xdebug sockets zip

RUN apt update && apt install -y wget git fish sudo

RUN curl --silent --show-error https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN useradd -s /usr/bin/fish -m zalex && echo 'zalex:password' | chpasswd && usermod -a -G sudo zalex
USER zalex

COPY . /usr/src/app

CMD ["php", "-v"]