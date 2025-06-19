FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
 
RUN npm install -g pnpm && pnpm install 

COPY . /app

RUN npm run build

FROM bitnami/laravel AS base

WORKDIR /app

RUN apt-get update && apt-get install -y \
    netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*

COPY . /app

COPY --from=frontend /app/public /app/public

RUN composer install --no-dev --optimize-autoloader

RUN bash ./scripts/init_env.sh

COPY wait-for-db.sh /usr/local/bin/wait-for-db.sh
RUN chmod +x /usr/local/bin/wait-for-db.sh
ENTRYPOINT ["sh", "-c", "\
    echo 'Waiting for MySQL at $DB_HOST:$DB_PORT…'; \
    wait-for-db.sh $DB_HOST $DB_PORT; \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan event:cache && \
    php artisan optimize && \
    php artisan migrate --force && \
    php artisan db:seed --force &&\
    php artisan serve --host=0.0.0.0 --port=${APP_PORT:-9000} \
"]
