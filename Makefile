-include .env
-include .env.local
-include tools/.colors

user	:= $(shell id -u)
group	:= $(shell id -g)

dc	:= USER_ID=$(user) GROUP_ID=$(group) docker-compose -f docker-compose.$(APP_ENV).yaml -p $(APP_DIR)_$(APP_ENV) --env-file .env
dr	:= $(dc) run --rm
de	:= $(dc) exec

njs := $(dr) node
php	:= $(dr) --no-deps php
sy	:= $(php) php bin/console

help:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}HELP (.env $(APP_ENV))"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo ""
	@echo "${BLUE}help${RESET} : Affiche cette aide"
	@echo ""
	@echo "${BLUE}cache/clear${RESET} : Permet de netoyer le cache de l'application"
	@echo "${BLUE}openssl/genrsa${RESET} : Permet de generer les certificats SSL"
	@echo "${BLUE}symfony/console ${RED}arg1${RESET} : Permet l'acces a la console symfony"
	@echo ""
	@echo "${PURPLE}# Console command"
	@echo "${BLUE}console ${RED}arg1${RESET} : Permet d'execute la commande ${RED}arg1${RESET} dans la console symfony."
	@echo ""
	@echo "${PURPLE}# Composer command"
	@echo "${BLUE}composer/require ${RED}arg1${RESET} : Permet l'installation du package ${RED}arg1${RESET}."
	@echo "${BLUE}composer/update${RESET} : Permet la mise a jours des dependances vers la derniere version."
	@echo ""
	@echo "${PURPLE}# Deployment command"
	@echo "${BLUE}deploy/local${RESET} : Deploiement des dockers en local pour le developpement."
	@echo ""
	@echo "${PURPLE}# Docker command"
	@echo "${BLUE}docker/build${RESET} : Permet la recuperation et la creation des differentes images."
	@echo "${BLUE}docker/compose/down${RESET} : Docker compose down."
	@echo "${BLUE}docker/compose/reset${RESET} : Docker compose down suivi d'un Docker compose up."
	@echo "${BLUE}docker/compose/up${RESET} : Docker compose up."
	@echo "${BLUE}docker/logs${RESET} : Permet l'affichage des logs du stack docker."
	@echo "${BLUE}docker/ps${RESET} : Permet l'affichage du tableau docker des containers du stack."
	@echo ""
	@echo "${PURPLE}# Doctrine command"
	@echo "${BLUE}doctrine/database/create${RESET} : Creation ou Update de l'ensemble des bases de donnee du projet."
	@echo "${BLUE}doctrine/fixtures/load${RESET} : Permet de charger des donnees pour les tests."
	@echo ""
	@echo "${PURPLE}# ENV command"
	@echo "${BLUE}env/dev${RESET} : Permet de generer l'environment de dev."
	@echo "${BLUE}env/local${RESET} : Permet de generer l'environment local."
	@echo "${BLUE}env/local/init${RESET} : Permet de generer l'environment local avec des questions."
	@echo "${BLUE}env/prod${RESET} : Permet de generer l'environment de prod."
	@echo ""
	@echo "${PURPLE}# Public command"
	@echo "${BLUE}public/assets${RESET} : Permet le deploiement des assets en prod."
	@echo "${BLUE}public/assets/dev${RESET} : Permet le deploiement des assets en dev."
	@echo ""
	@echo "${PURPLE}# PHPUnit command"
	@echo "${BLUE}phpunit${RESET} : Permet l'execution des tests de l'application."
	@echo "${BLUE}phpunit/coverage${RESET} : Permet la generation du fichier de coverage."
	@echo "${BLUE}phpunit/testdox${RESET} : Permet l'execution des tests avec l'affichage testdox."
	@echo "${BLUE}phpunit/testsuite ${RED}arg1${RESET} : Permet l'execution des tests specifique."
	@echo "${BLUE}phpunit/testsuite/testdox ${RED}arg1${RESET} : Permet l'execution des tests specifique avec l'affichage testdox."
	@echo ""
	@echo "${PURPLE}# Swagger command"
	@echo "${BLUE}swagger${RESET} : Permet de generer le fichier de configuration swagger."
	@echo ""
	@echo "${PURPLE}# Translation command"
	@echo "${BLUE}translation${RESET} : Permet de generer les fichiers i18n."

cache/clear:
	$(sy) cache:clear

console:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}console ${RED}" $(filter-out $@,$(MAKECMDGOALS))
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) php bin/console $(filter-out $@,$(MAKECMDGOALS))

composer/require:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}composer/require ${RED}" $(filter-out $@,$(MAKECMDGOALS))
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) composer require -W $(filter-out $@,$(MAKECMDGOALS))

composer/update:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}composer/update"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) composer update --no-interaction

deploy/local:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}deploy/local"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	@make env/local
	@make docker/build
	@make composer/update
	@make public/assets/dev
	@make openssl/genrsa
	@make docker/compose/up
	@make doctrine/database/create
	@make console app:system:init

docker/build:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/build"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) pull --ignore-pull-failures
	$(dc) build
	docker build -t $(APP_DIR)_$(APP_ENV)_node:latest ./docker/node/

docker/compose/down:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/compose/down"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) down

docker/compose/reset:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/compose/reset"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	@make docker/compose/down
	@make docker/compose/up

docker/compose/restart:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/compose/restart"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) restart

docker/compose/up:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/compose/up"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) up -d
	$(dc) rm -f node

docker/logs:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/logs"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) logs -f

docker/ps:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}docker/ps"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(dc) ps

doctrine/database/create:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}doctrine/database/create"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	@sleep 30
	$(sy) doctrine:database:create -c mysql --if-not-exists
	$(sy) doctrine:database:create -c local
	$(sy) doctrine:schema:update --force --em mysql
	$(sy) doctrine:schema:update --force --em local

doctrine/fixtures/load:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}doctrine/fixtures/load"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(sy) doctrine:fixtures:load -q

env/dev:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}env/dev"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	rm .env -f
	rm app/.env -f
	cat env/.env >> .env
	cat env/.env.dev >> .env
	cat env/.env.dev.github >> .env
	@bash env/app.sh

env/init:
	rm env/.env -f
	rm env/.env.tmp -f
	@bash env/init.sh

env/local:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}env/local"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	rm .env -f
	rm app/.env -f
	cat env/.env >> .env
	cat env/.env.local >> .env
	@bash env/app.sh

env/local/init:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}env/local/init"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	rm env/.env.local -f
	@bash env/local.sh

env/prod:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}env/prod"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	rm .env -f
	rm ./app/.env -f
	cat env/.env >> .env
	cat env/.env.prod >> .env
	cat env/.env.prod.github >> .env
	@bash env/app.sh

openssl/genrsa:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}openssl/genrsa"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	openssl genrsa -out ./app/config/jwt/private_key.pem 4096
	openssl rsa -pubout -in ./app/config/jwt/private_key.pem -out ./app/config/jwt/public_key.pem

public/assets:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}public/assets"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(njs) yarn
	$(njs) yarn run build

public/assets/dev:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}public/assets/dev"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(njs) yarn
	$(njs) yarn run dev

phpunit:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}phpunit"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	rm -f ./app/phpunit.xml
	$(php) ./vendor/bin/phpunit --configuration phpunit.xml.dist

phpunit/coverage:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}phpunit/coverage"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./vendor/bin/phpunit --configuration phpunit.xml.dist --testsuite API --testsuite Kernel --testsuite Unit --testsuite Web --coverage-clover coverage.xml

phpunit/testdox:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}phpunit/testdox"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./vendor/bin/phpunit --configuration phpunit.xml.dist --testdox

phpunit/testsuite:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}phpunit/testsuite"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./vendor/bin/phpunit --configuration phpunit.xml.dist --testsuite $(filter-out $@,$(MAKECMDGOALS))

phpunit/testsuite/testdox:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}phpunit/testsuite/testdox"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./vendor/bin/phpunit --configuration phpunit.xml.dist --testsuite $(filter-out $@,$(MAKECMDGOALS)) --testdox

swagger:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}swagger"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./vendor/bin/openapi --format json --output ./swagger.json ./config/swagger.php ./src/

symfony/console:
	$(sy) $(filter-out $@,$(MAKECMDGOALS))

translation:
	@echo "${PURPLE}################################################################################################"
	@echo "${PURPLE}#"
	@echo "${PURPLE}# ${RESET}translation"
	@echo "${PURPLE}#"
	@echo "${PURPLE}################################################################################################"
	@echo "${RESET}"
	$(php) ./bin/console translation:extract --format yaml --force en
	$(php) ./bin/console translation:extract --format yaml --force fr

%:
	@: