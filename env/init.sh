#!/bin/bash

write_var_env(){
  var=$1
  echo "$1=\"$2\"" >> env/.env
}

write_var_env_tmp(){
  var=$1
  echo "$1=\"$2\"" >> env/.env.tmp
}

echo -n "APP DIR (symfony_docker_project) : "
read APP_DIR
if [ -z "$APP_DIR" ]
then
  write_var_env "APP_DIR" "symfony_docker_project"
  APP_DIR="symfony_docker_project"
else
  write_var_env "APP_DIR" $APP_DIR
fi

echo -n "APP NAME (symfony docker project) : "
read APP_NAME
if [ -z "$APP_NAME" ]
then
  write_var_env "APP_NAME" "symfony docker project"
  APP_NAME="symfony docker project"
else
  write_var_env "APP_NAME" $APP_NAME
fi

echo -n "Project ID : "
read APP_ID
if [ -z "$APP_ID" ]
then
  echo "ERROR"
  exit 0
fi

echo -n "Port start : "
read APP_PORT
if [ -z "$APP_PORT" ]
then
  echo "ERROR"
  exit 0
fi


write_var_env_tmp "APP_ENV" "dev"
write_var_env_tmp "APP_URI" "https://env-$APP_ID.local.pwsb.fr"
write_var_env_tmp "APP_SECRET" "SECRET123456789"
write_var_env_tmp "DOCKER_DATABASE_URI" "https://env-$APP_ID.local.pwsb.fr/phpmyadmin/"
write_var_env_tmp "DOCKER_DATABASE_PASSWORD" "password1234"
write_var_env_tmp "DOCKER_NGINX_PORT" "$APP_PORT"
write_var_env_tmp "DOCKER_MINIO_CONSOLE" "https://env-$APP_ID.console.minio.local.pwsb.fr"
write_var_env_tmp "DOCKER_MINIO_CONSOLE_PORT" "$(($APP_PORT + 2))"
write_var_env_tmp "DOCKER_MINIO_ENDPOINT" "https://env-$APP_ID.minio.local.pwsb.fr"
write_var_env_tmp "DOCKER_MINIO_ENDPOINT_PORT" "$(($APP_PORT + 1))"
write_var_env_tmp "DOCKER_MINIO_KEY" "minio"
write_var_env_tmp "DOCKER_MINIO_SECRET" "minio1234"
write_var_env_tmp "MAILER_DSN" "smtp://maildev:1025?verify_peer=0"
write_var_env_tmp "MESSENGER_TRANSPORT_DSN" "redis://redis:6379"