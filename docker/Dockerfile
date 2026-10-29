# All-in-one image: Selfoss (RSS reader) + Selfoss-Webfront (newspaper UI)
#
# Selfoss serves on port 8080, the webfront on port 80.
# Selfoss version defaults to the latest release; override with
# --build-arg SELFOSS_VERSION=<version>.

FROM php:8.3-apache

ARG SELFOSS_VERSION=2.19

LABEL org.opencontainers.image.title="selfoss-webfront" \
      org.opencontainers.image.description="Selfoss RSS reader bundled with the newspaper-style Selfoss-Webfront" \
      org.opencontainers.image.authors="Matthias Karl" \
      org.opencontainers.image.licenses="MIT" \
      org.opencontainers.image.source="https://github.com/MatthK/Selfoss-Webfront"

ENV SELFOSS_VERSION=${SELFOSS_VERSION} \
    DEBIAN_FRONTEND=noninteractive \
    SELFOSS_UPDATE_INTERVAL=900

RUN a2enmod headers rewrite \
    && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
               ca-certificates \
               curl \
               unzip \
               libfreetype6-dev \
               libjpeg62-turbo-dev \
               libpng-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql

# Selfoss (the release zip ships vendor + built assets, no composer/npm build needed)
ADD https://github.com/fossar/selfoss/releases/download/${SELFOSS_VERSION}/selfoss-${SELFOSS_VERSION}.zip /tmp/
RUN unzip -q /tmp/selfoss-${SELFOSS_VERSION}.zip -d /tmp/selfoss \
    && rm /tmp/selfoss-${SELFOSS_VERSION}.zip \
    && rm -rf /var/www/html \
    && mv /tmp/selfoss/selfoss /var/www/html \
    && rm -rf /tmp/selfoss \
    && mkdir -p /var/www/html/data/logs \
    && ln -s /var/www/html/data/config.ini /var/www/html/config.ini \
    && chown -R www-data:www-data /var/www/html

# Webfront
COPY index.php tag.php article.php search.php /var/www/webfront/
COPY api/ /var/www/webfront/api/
COPY includes/ /var/www/webfront/includes/
COPY assets/ /var/www/webfront/assets/
COPY db/ /var/www/webfront/db/
RUN chown -R www-data:www-data /var/www/webfront

COPY docker/php.ini /usr/local/etc/php/conf.d/webfront.ini
COPY docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/init_db.php /usr/local/bin/webfront-init.php
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh /usr/local/bin/webfront-init.php

VOLUME /var/www/html/data

HEALTHCHECK --interval=1m --timeout=10s --retries=3 \
    CMD curl -sf http://localhost/ >/dev/null || exit 1; curl -sf http://localhost:8080/ >/dev/null || exit 1

ENTRYPOINT ["/entrypoint.sh"]
