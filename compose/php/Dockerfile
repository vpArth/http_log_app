FROM php:7-cli

RUN apt-get update -y && apt-get install -y git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/code
COPY . dev
RUN (cd dev; composer install)
# RUN git clone dev prod; (cd prod; composer dump-env prod; composer install --no-dev --optimize-autoloader)


FROM php:7-fpm
WORKDIR /var/code
COPY --from=0 /var/code/dev  dev
# COPY --from=0 /var/code/prod prod
RUN chmod -R o+w /var/code/dev/var

