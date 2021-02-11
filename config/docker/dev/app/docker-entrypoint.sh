#!/usr/bin/env bash

cd /app

[[ -d "/app/var" ]] || mkdir -m 0777 "/app/var"
[[ -d "/app/var/cache" ]] || mkdir -m 0777 "/app/var/cache"
[[ -d "/app/var/logs" ]] || mkdir -m 0777 "/app/var/logs"
[[ -d "/app/var/tmp" ]] || mkdir -m 0777 "/app/var/tmp"

if [[ "$XDEBUG" = true ]] ; then
    mv /tmp/xdebug.ini /etc/php8/conf.d/xdebug.ini
fi

shopt -s nullglob
for f in /app/.env*.docker
do
	  mv $f "${f/docker/local}"
done

sleep 2

/usr/sbin/php-fpm8 --nodaemonize
