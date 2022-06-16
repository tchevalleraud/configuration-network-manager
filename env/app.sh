#!/bin/bash

closeBlock(){
   var=$1
   echo "###< $1" >> ./app/.env
   echo "" >> ./app/.env
}

openBlock(){
   var=$1
   echo "###> $1" >> ./app/.env
}

read_var() {
    VAR=$(grep $1 $2 | xargs)
    IFS="=" read -ra VAR <<< "$VAR"
    echo ${VAR[1]}
}

write_var() {
  var=$1
  echo "$1=$2" >> ./app/.env
}

openBlock "coraxster/flysystem-aws-s3-v3-minio"
write_var "MINIO_CONSOLE" $(read_var DOCKER_MINIO_CONSOLE .env)
write_var "MINIO_ENDPOINT" $(read_var DOCKER_MINIO_ENDPOINT .env)
write_var "MINIO_KEY" $(read_var DOCKER_MINIO_KEY .env)
write_var "MINIO_SECRET" $(read_var DOCKER_MINIO_SECRET .env)
closeBlock "coraxster/flysystem-aws-s3-v3-minio"

openBlock "doctrine/doctrine-bundle"
write_var "DATABASE_LOCAL_URL" "sqlite:///%kernel.project_dir%/var/local.db"
write_var "DATABASE_MYSQL_URL" "mysql://root:"$(read_var DOCKER_DATABASE_PASSWORD .env)"@database:3306/configuration_network_manager"
closeBlock "doctrine/doctrine-bundle"

openBlock "symfony/framework-bundle"
write_var "APP_ENV" $(read_var APP_ENV .env)
write_var "APP_NAME" "\"$(read_var APP_NAME .env)\""
write_var "APP_URI" $(read_var APP_URI .env)
write_var "APP_SECRET" $(read_var APP_SECRET .env)
closeBlock "symfony/framework-bundle"

openBlock "symfony/mailer"
write_var "MAILER_DSN" $(read_var MAILER_DSN .env)
closeBlock "symfony/mailer"

openBlock "symfony/messenger"
write_var "MESSENGER_TRANSPORT_DSN" $(read_var MESSENGER_TRANSPORT_DSN .env)
closeBlock "symfony/messenger"