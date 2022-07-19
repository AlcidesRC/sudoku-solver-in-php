.DEFAULT_GOAL := help

# CONSTANTS - COLORS

ifneq (,$(findstring xterm,${TERM}))
	YELLOW  := $(shell tput -Txterm setaf 3)
	RESET   := $(shell tput -Txterm sgr0)
else
	YELLOW  := ""
	RESET   := ""
endif

# CONSTANTS - SERVICE

SERVICE_NAME 		= php-fpm

DOCKER_COMPOSE 		= @docker-compose
DOCKER_COMPOSE_EXEC = ${DOCKER_COMPOSE} exec ${SERVICE_NAME}

# DOCKER-RELATED COMMANDS

bash: CMD=bash 							## Opens a Bash terminal with main service
build: CMD=build 						## Builds the service
down: CMD=down 							## Stops the service
logs: CMD=logs ${SERVICE_NAME} 			## Exposes the service logs
restart: CMD=restart ${SERVICE_NAME} 	## Restarts the service
up: CMD=up --remove-orphans -d 			## Starts the service

build down logs restart up:
	${DOCKER_COMPOSE} ${CMD}
	@echo ""

# COMPOSER-RELATED COMMANDS

composer-dump: CMD=composer dump-auto --optimize 																	## Runs <composer dump-auto>
composer-install: CMD=composer install --optimize-autoloader														## Runs <composer install>
composer-remove: CMD=composer remove --optimize-autoloader --with-all-dependencies $(filter-out $@,$(MAKECMDGOALS))	## Runs <composer remove PACKAGE-NAME>
composer-require-dev: CMD=composer require --optimize-autoloader --with-all-dependencies --dev						## Runs <composer require-dev>
composer-require: CMD=composer require --optimize-autoloader --with-all-dependencies								## Runs <composer require>
composer-update: CMD=composer update --optimize-autoloader --with-all-dependencies									## Runs <composer update>

composer-install composer-update composer-require composer-require-dev composer-remove composer-dump:
	${DOCKER_COMPOSE_EXEC} ${CMD} --ignore-platform-reqs --no-scripts --no-plugins --ansi --profile
	@echo ""

# ADDITIONAL COMMANDS

metrics-phpmetrics: CMD=./vendor/bin/phpmetrics --junit=./coverage/junit.xml --report-html=./metrics ./app
qa-linter: CMD=./vendor/bin/parallel-lint -e php -j 10 --colors ./app ./tests
qa-phpcsfixer: CMD=./vendor/bin/php-cs-fixer fix --using-cache=no --ansi
qa-phpstan: CMD=./vendor/bin/phpstan analyse --level 9 --memory-limit 1G --ansi ./app ./tests
qa-phpinsights: CMD=./vendor/bin/phpinsights --fix
tests-infection: CMD=./vendor/bin/infection --configuration=infection.json --threads=3 --coverage=./.reports/coverage --ansi
tests-paratest: CMD=php -d pcov.enabled=1 vendor/bin/paratest --passthru-php="'-d' 'pcov.enabled=1'" --coverage-text --coverage-xml=./.reports/coverage/xml --coverage-html=./.reports/coverage/html --log-junit=./.reports/coverage/junit.xml
tests-phpunit: CMD=./vendor/bin/phpunit --coverage-text --coverage-xml=./.reports/coverage/xml --coverage-html=./.reports/coverage/html --log-junit=./.reports/coverage/junit.xml --coverage-cache .cache/coverage

bash qa-linter qa-phpstan qa-phpcsfixer qa-phpinsights tests-phpunit tests-paratest tests-infection metrics-phpmetrics:
	${DOCKER_COMPOSE_EXEC} ${CMD}
	@echo ""

# SHORTCUTS

metrics: metrics-phpmetrics ## Generates a report with some metrics
qa: qa-linter qa-phpcsfixer qa-phpstan qa-phpinsights ## Checks the source code
tests: tests-paratest tests-infection ## Runs the Tests Suites

# MISCELANEOUS

example-cli: ## Executes the example via CLI
	${DOCKER_COMPOSE_EXEC} php ./cli/example.php
	@echo ""

example-html: ## Executes the example via HTTP
	@xdg-open http://localhost
	@echo ""

# HELP

help:
	@clear
	@echo "╔══════════════════════════════════════════════════════════════════════════════╗"
	@echo "║                                                                              ║"
	@echo "║                           ${YELLOW}.:${RESET} AVAILABLE COMMANDS ${YELLOW}:.${RESET}                           ║"
	@echo "║                                                                              ║"
	@echo "╚══════════════════════════════════════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_0-9%-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "· ${YELLOW}%-30s${RESET} %s\n", $$1, $$2}'
	@echo ""