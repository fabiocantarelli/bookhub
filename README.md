# Bookhub

<p align="center">
  <img src="assets/images/logo/bookhub_logo_1.png" alt="Bookhub Logo" width="200" />
</p>

  <div align="center">
    <a href="https://php.net/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/PHP-8.4-blue?labelColor=17191E&style=flat&logo=PHP" alt="PHP 8.4">
    </a>
    <a href="https://symfony.com/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/symfony-7.3.0-white?labelColor=17191E&style=flat&logo=Symfony" alt="Symfony 7.3.0">
    </a>
    <a href="https://nodejs.org/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/Node.js-22.16.0-green?labelColor=17191E&style=flat&logo=Node.js" alt="Node.js">
    </a>
    <a href="https://getcomposer.org/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/Composer-latest-black?labelColor=17191E&style=flat&logo=Composer" alt="Composer">
    </a>
    <a href="https://getbootstrap.com/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/bootstrap-5.3.6-purple?labelColor=17191E&style=flat&logo=Bootstrap" alt="Bootstrap 5.3.6">
    </a>
    <a href="https://nginx.org/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/Nginx-latest-blue?labelColor=17191E&style=flat&logo=Nginx" alt="Nginx">
    </a>
    <a href="https://mysql.com/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/MySQL-8.0-blue?labelColor=17191E&style=flat&logo=MySQL" alt="MySQL">
    </a>
    <a href="https://docker.com/" target="_blank" class="m-1">
      <img src="https://img.shields.io/badge/Docker-28.1.1-blue?labelColor=17191E&style=flat&logo=Docker" alt="Docker">
    </a>
  </div>

<br>
<br>

**Bookhub** é um sistema web de gestão de acervo bibliográfico que permite:

- Cadastrar, editar, visualizar e remover **Livros**, **Autores** e **Assuntos**.  
- Relacionar livros a múltiplos autores e assuntos de forma flexível.  
- Gerar relatórios a partir de uma _view_ no banco de dados, agrupando por autor e exibindo título, assunto, data de publicação e valor do livro.  

Em essência, o Bookhub serve como ponto central para organizar e consultar informações sobre obras literárias, seguindo boas práticas de desenvolvimento (camada de persistência, tratamento de erros específicos, formatação de campos, uso de CSS/Bootstrap, testes automatizados e geração de relatórios).

## Geração de Relatórios em PDF

O sistema utiliza o [**KnpSnappyBundle**](https://github.com/KnpLabs/KnpSnappyBundle) em conjunto com o **wkhtmltopdf** para converter templates HTML em arquivos PDF. Essa integração é utilizada para gerar os relatórios do acervo de forma automatizada e com layout consistente.

## 🐋 Ambiente de Execução Docker

O projeto roda em **Docker** utilizando uma imagem personalizada definida em `docker/config/php/Dockerfile`, orquestrada via **docker-compose**.
Alternativamente, também é possível rodar o projeto fora do Docker, desde que todos os pacotes e extensões listados no Dockerfile estejam devidamente instalados no ambiente local.


---

## Como rodar o projeto

Siga os passos abaixo para configurar e iniciar o Bookhub utilizando Docker:

**Obs:** Os comandos abaixo também estão presentes no makefile, caso tenha o pacote **make** instalado, basta rodar `make help`

1. **Configuração de variáveis de ambiente**
   Copie o arquivo de exemplo e ajuste as credenciais de acesso ao MySQL:

   ```bash
   cp .env .env.local
   ```

   Preencha em `.env.local`:

   ```ini
   MYSQL_DATABASE=bookhub
   MYSQL_USER=bookhub
   MYSQL_PASSWORD=bookhub
   MYSQL_ROOT_PASSWORD=root
   ```

2. **Build e inicialização dos containers**

   ```bash
   docker compose up -d --build
   ```

3. **Instalação de dependências**
   Execute os comandos abaixo dentro do container PHP
   
   Instalação de depêndencias composer:
   ```bash
   docker exec -it bookhub-php composer install
   ```
   Instalação de depêndencias node:
   ```bash
   docker exec -it bookhub-php npm install
   ```

4. **Compilação dos assets**

   ```bash
   docker exec -it bookhub-php npm run dev
   ```

5. **Migrações do banco de dados**

   ```bash
   docker exec -it bookhub-php bin/console doctrine:migration:migrate
   ```

Pronto! O Bookhub estará disponível em `http://localhost` (ou na porta configurada).

1. **Carregamento de fixtures dev Autor / Assunto / Livros (opcional)**

   ```bash
   docker exec -it bookhub-php bin/console doctrine:fixtures:load --append
   ```
2. **Ajuste de permissões (opcional, caso ocorram erros de permissão)**

   Caso você encontre problemas de permissão ao rodar os comandos acima, execute no host:

   ```bash
   sudo chown $(whoami):www-data -R .
   ```

   Caso aja erro de permissões relacionadas a cache:
    ```bash
   sudo chmod 777 -R var/
   ```
---

## Configuração de rotas

```bash
 --------------------- -------- -------- ------ -------------------------- 
  Name                  Method   Scheme   Host   Path                      
 --------------------- -------- -------- ------ -------------------------- 
  _preview_error        ANY      ANY      ANY    /_error/{code}.{_format}  
  app_author_index      GET      ANY      ANY    /author/                  
  app_author_new        POST     ANY      ANY    /author/                  
  app_author_edit       PUT      ANY      ANY    /author/{id}              
  app_author_delete     DELETE   ANY      ANY    /author/{id}              
  app_book_index        GET      ANY      ANY    /book/                    
  app_book_new          POST     ANY      ANY    /book/                    
  app_book_edit         PUT      ANY      ANY    /book/{id}                
  app_book_delete       DELETE   ANY      ANY    /book/{id}                
  app_home_index        ANY      ANY      ANY    /                         
  app_report_generate   GET      ANY      ANY    /report/generate          
  app_subject_index     GET      ANY      ANY    /subject/                 
  app_subject_new       POST     ANY      ANY    /subject/                 
  app_subject_edit      PUT      ANY      ANY    /subject/{id}             
  app_subject_delete    DELETE   ANY      ANY    /subject/{id}             
 --------------------- -------- -------- ------ --------------------------
 ```
