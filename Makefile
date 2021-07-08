DOCKER_COMPOSE = docker-compose
EXEC_PHP = $(DOCKER_COMPOSE) exec php-fpm
EXEC_PHP_TEST = $(DOCKER_COMPOSE) --file-env .env.test exec php-fpm
SYMFONY = $(EXEC_PHP) bin/console
COMPOSER = $(EXEC_PHP) composer
PHP_UNIT = $(EXEC_PHP) vendor/bin/phpunit


install: ## install
install: vendor
		docker network create devolon_shopping_cart
		$(DOCKER_COMPOSE) build
		$(DOCKER_COMPOSE) run --rm php-fpm composer install
		$(DOCKER_COMPOSE) up -d --restart=unless-stopped

login-php: ## login to php docker
login-php:
	docker exec -it develonshoppingcart_php-fpm_1 /bin/bash

test: ## Run phpunit tests
test:
	$(PHP_UNIT)  --configuration /var/www/phpunit.xml.dist /var/www/tests

composer: ## run composer
composer:
	$(COMPOSER) $(filter-out $@,$(MAKECMDGOALS))

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'