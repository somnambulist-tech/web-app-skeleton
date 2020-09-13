FROM nginx:alpine
ENV REFRESHED_AT=2020-08-07

COPY ./config/docker/prod/web/conf.d/*.conf /etc/nginx/conf.d/
COPY ./public /app/public
