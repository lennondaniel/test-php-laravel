FROM php:8.2-fpm-alpine

RUN apk --update add wget \
  curl \
  git \
  grep \
  build-base \
  libmcrypt-dev \
  libxml2-dev \
  imagemagick-dev \
  pcre-dev \
  libtool \
  make \
  autoconf \
  g++ \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor \
  libpq-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql xml
RUN pecl channel-update pecl.php.net \
    && pecl install imagick \
    && docker-php-ext-enable imagick pdo_pgsql

# I recommend being explicit with node version here...
# but we'll see if livewire complains
RUN apk add --update nodejs \
    && apk add --update npm

RUN rm /var/cache/apk/* && \
    mkdir -p /var/www

COPY ./dev/docker-compose/php/supervisord-app.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

