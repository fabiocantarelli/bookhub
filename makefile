## 👷 Makefile
## ______________________________________________________________________________________________________
##

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' \
		| sed -e 's/\[32m##/\[33m/'

## ______________________________________________________________________________________________________
##
## 📦 Instalação do projeto
## ______________________________________________________________________________________________________
##
start: up composer-i npm-i run-dev run-migrations ## Configura todo o projeto

## ______________________________________________________________________________________________________
##
## 📦 Docker Manager Containers
## ______________________________________________________________________________________________________
##
up: ## Build e sobe todos os containers
	@docker compose up -d --build

down: ## Baixa todos os containers
	@docker compose down

restart: down up ## Restart dos containers docker

php-bash: ## Abre terminal bash no container PHP
	@docker exec -it bookhub-php bash

## ______________________________________________________________________________________________________
##
## 📦 Composer / Node
## ______________________________________________________________________________________________________
##
composer-i: ## Instala dependências Composer
	@docker exec -it bookhub-php composer install

npm-i: ## Instala dependências Node
	@docker exec -it bookhub-php npm install

run-dev: ## Compila assets em modo dev
	@docker exec -it bookhub-php npm run dev

## ______________________________________________________________________________________________________
##
## 🛠 Symfony
## ______________________________________________________________________________________________________
##
run-migrations: ## Executa migrações do banco
	@docker exec -it bookhub-php bin/console doctrine:migration:migrate --no-interaction

run-fixtures-dev: ## Carrega fixtures de desenvolvimento
	@docker exec -it bookhub-php bin/console doctrine:fixtures:load --append --no-interaction

## ______________________________________________________________________________________________________
##
## 🔧 Permissões (opcional)
## ______________________________________________________________________________________________________
##
perms: ## Ajuste de permissões em caso de erros
	@sudo chown $(shell whoami):www-data -R .
	@sudo chmod 777 -R var/

## ______________________________________________________________________________________________________
##
## 🪲 Tests de Código
## ______________________________________________________________________________________________________
##
phpstan: ## Testes php stan
	@docker exec -it bookhub-php composer phpstan

phpcs: ## Testes code sniffer
	@docker exec -it bookhub-php composer phpcs

## ______________________________________________________________________________________________________