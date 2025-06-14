## 👷 Makefile
## ___________________________________________________
##

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' \
		| sed -e 's/\[32m##/\[33m/'

## ___________________________________________________
##
## 📦 Docker Manager Containers
## ___________________________________________________

up: ## Build e sobe todos os containers
	@docker compose up -d --build

down: ## Baixa todos os containers
	@docker compose down

restart: down up ## Restart dos containers docker

php-bash: ## Abre terminal bash no container PHP
	@docker exec -it bookhub-php bash

## ___________________________________________________
##
## 📦 Composer / Node
## ___________________________________________________

composer-install: ## Instala dependências Composer
	@docker exec -it bookhub-php composer install

npm-install: ## Instala dependências Node
	@docker exec -it bookhub-php npm install

run-dev: ## Compila assets em modo dev
	@docker exec -it bookhub-php npm run dev

## ___________________________________________________
##
## 🛠 Symfony
## ___________________________________________________

run-migration: ## Executa migrações do banco
	@docker exec -it bookhub-php bin/console doctrine:migration:migrate

run-fixtures-dev: ## Carrega fixtures de desenvolvimento
	@docker exec -it bookhub-php bin/console doctrine:fixtures:load --append

## ___________________________________________________
##
## 🔧 Permissões (opcional)
## ___________________________________________________

perms: ## Ajuste de permissões em caso de erros
	@sudo chown $(shell whoami):www-data -R .
	@sudo chmod 777 -R var/
