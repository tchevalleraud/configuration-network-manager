#!/bin/bash

write_var(){
  var=$1
  echo "$1=$2" >> ./env/.env.local
}

write_var "APP_ENV" "dev"

echo -n "APP URI [http://localhost] : "
read APP_URI
if [ -z "$APP_URI" ]
then
  write_var "APP_URI" "http://localhost"
  APP_URI="http://localhost"
else
  write_var "APP_URI" $APP_URI
fi

echo -n "APP SECRET [SECRET123456789] : "
read APP_SECRET
if [ -z "$APP_SECRET" ]
then
  write_var "APP_SECRET" "SECRET123456789"
  APP_SECRET="SECRET123456789"
else
  write_var "APP_SECRET" $APP_SECRET
fi

echo -n "PHPMyAdmin URI [$APP_URI/phpmyadmin] : "
read DOCKER_DATABASE_URI
if [ -z "$DOCKER_DATABASE_URI" ]
then
  write_var "DOCKER_DATABASE_URI" $APP_URI/phpmyadmin
  DOCKER_DATABASE_URI=$APP_URI/phpmyadmin
else
  write_var "DOCKER_DATABASE_URI" $DOCKER_DATABASE_URI
fi

echo -n "Database password [password1234] : "
read DOCKER_DATABASE_PASSWORD
if [ -z "$DOCKER_DATABASE_PASSWORD" ]
then
  write_var "DOCKER_DATABASE_PASSWORD" "password1234"
  DOCKER_DATABASE_PASSWORD="password1234"
else
  write_var "DOCKER_DATABASE_PASSWORD" $DOCKER_DATABASE_URI
fi

echo -n "NGINX public port [80] : "
read DOCKER_NGINX_PORT
if [ -z "$DOCKER_NGINX_PORT" ]
then
  write_var "DOCKER_NGINX_PORT" "80"
  DOCKER_NGINX_PORT="80"
else
  write_var "DOCKER_NGINX_PORT" $DOCKER_NGINX_PORT
fi

echo -n "Minio console URI [$APP_URI/minio/console] : "
read DOCKER_MINIO_CONSOLE
if [ -z "$DOCKER_MINIO_CONSOLE" ]
then
  write_var "DOCKER_MINIO_CONSOLE" "$APP_URI/minio/console"
  DOCKER_MINIO_CONSOLE="$APP_URI/minio/console"
else
  write_var "DOCKER_MINIO_CONSOLE" $DOCKER_MINIO_CONSOLE
fi

echo -n "Minio console public port [9001] : "
read DOCKER_MINIO_CONSOLE_PORT
if [ -z "$DOCKER_MINIO_CONSOLE_PORT" ]
then
  write_var "DOCKER_MINIO_CONSOLE_PORT" "9001"
  DOCKER_MINIO_CONSOLE_PORT="9001"
else
  write_var "DOCKER_MINIO_CONSOLE_PORT" $DOCKER_MINIO_CONSOLE_PORT
fi

echo -n "Minio URI [$APP_URI/minio] : "
read DOCKER_MINIO_ENDPOINT
if [ -z "$DOCKER_MINIO_ENDPOINT" ]
then
  write_var "DOCKER_MINIO_ENDPOINT" "$APP_URI/minio"
  DOCKER_MINIO_ENDPOINT="$APP_URI/minio"
else
  write_var "DOCKER_MINIO_ENDPOINT" $DOCKER_MINIO_ENDPOINT
fi

echo -n "Minio public port [9000] : "
read DOCKER_MINIO_ENDPOINT_PORT
if [ -z "$DOCKER_MINIO_ENDPOINT_PORT" ]
then
  write_var "DOCKER_MINIO_ENDPOINT_PORT" "9000"
  DOCKER_MINIO_ENDPOINT_PORT="9000"
else
  write_var "DOCKER_MINIO_ENDPOINT_PORT" $DOCKER_MINIO_ENDPOINT_PORT
fi

echo -n "Minio User [minio] : "
read DOCKER_MINIO_KEY
if [ -z "$DOCKER_MINIO_KEY" ]
then
  write_var "DOCKER_MINIO_KEY" "minio"
  DOCKER_MINIO_KEY="minio"
else
  write_var "DOCKER_MINIO_KEY" $DOCKER_MINIO_KEY
fi

echo -n "Minio Password [minio1234] : "
read DOCKER_MINIO_SECRET
if [ -z "$DOCKER_MINIO_SECRET" ]
then
  write_var "DOCKER_MINIO_SECRET" "minio1234"
  DOCKER_MINIO_SECRET="minio1234"
else
  write_var "DOCKER_MINIO_SECRET" $DOCKER_MINIO_SECRET
fi

write_var "MAILER_DSN" "smtp://maildev:1025?verify_peer=0"
write_var "MESSENGER_TRANSPORT_DSN" "redis://redis:6379"