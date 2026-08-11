# syntax=docker/dockerfile:1

FROM php:8.2.28-cli-bookworm AS dependencies

WORKDIR /app

COPY --from=composer:2.8.8 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install --yes --no-install-recommends libzip-dev \
    && docker-php-ext-install -j"$(nproc)" mysqli zip \
    && rm -rf /var/lib/apt/lists/*

COPY composer.json composer.lock ./

# ext-http is declared but not used by the application. It is intentionally not
# installed in the runtime image; mysqli is the only PHP extension required.
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-req=ext-http

FROM php:8.2.28-cli-bookworm AS runtime

WORKDIR /app

RUN docker-php-ext-install -j"$(nproc)" mysqli \
    && groupadd --gid 10001 app \
    && useradd --uid 10001 --gid app --create-home --shell /usr/sbin/nologin app

COPY --chown=app:app . ./
COPY --from=dependencies --chown=app:app /app/vendor ./vendor

RUN mkdir -p public/upload \
    && chown -R app:app public/upload

ENV APP_ENV=production

EXPOSE 8000

USER app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
