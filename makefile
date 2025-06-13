## 👷 Makefile
## ___________________________________________________
##

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## ___________________________________________________
##
## 📦 Docker Manager Containers
## ________
##

up-d: ## Up all containers
	@docker compose up -d

down: ## Down all containers
	@docker compose down

restart: down up-d ## Restart all containers

php-bash: ## Open bash in php container
	@docker exec -it bookhub-php bash

## ___________________________________________________
##
## Composer / Node
## ________
##
composer-install: ## Install composer dependencies
	@docker exec -it bookhub-php composer install

npm-install: ## Install node dependencies
	@docker exec -it bookhub-php npm install

npm-run: ## Run npm script
	@docker exec -it bookhub-php npm run $(script)

## ___________________________________________________