include .env

PHP_PORT ?= 80
php := $(shell which php)
composer := $(shell which composer)
mysql := mysql -h $(DB_HOST) -P $(DB_PORT) -u $(DB_USER) -p'$(DB_PASSWORD)' --force

start:
	@printf "\033[32;49m *** Downloading composer dependencies *** \033[39m\n"	
	@$(composer) install
.PHONY: start

run:
	@printf "\033[32;49m *** Starting PHP Server *** \033[39m\n"
	@$(php) -S 127.0.0.1:$(PHP_PORT)
.PHONY: run

DATABASE_CREATE_COMMAND ?= $(mysql) -e "CREATE DATABASE IF NOT EXISTS \`$(DB_NAME)\`;"
database:
	@printf "033[32;49m *** Creating database *** \033[39m\n"
	@$(DATABASE_CREATE_COMMAND)
.PHONY: database