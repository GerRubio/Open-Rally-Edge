#!/bin/bash

UID = $(shell id -u)
DOCKER_BE = open-rally-edge-core

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	docker network create open-rally-edge-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install

run: ## Starts the Symfony development server
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony serve -d

logs: ## Show Symfony logs in real time
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony server:log

# Backend commands
composer-install: ## Installs Composer dependencies
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} composer install --no-interaction
# End backend commands

ssh-be: ## Bash into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

code-style: ## Runs PHP-CS to fix code styling following Symfony rules
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony