<img src="https://github.com/Pierre-Mendes/First-Challenge-Bootcamp-Java-DIO/assets/63386178/da4a13ca-375c-4546-99e5-034786980e47" alt="Banner" style="width:100%;" />

---

# 🧪 Teste Técnico

![PHP Version](https://img.shields.io/badge/PHP-8.4-blue)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-finalizado-brightgreen)

Este repositório contém a solução para o **teste técnico**, com o objetivo de demonstrar habilidades em:

> **PHP · Laravel · SQL · POO · Design Patterns · Boas práticas de desenvolvimento**

---

## 🎯 Desafio

Criação de endpoints para um sistema de gerenciamento bancário:

- 🔹 Um endpoint `Get` para **gerenciamento de contas**
- 🔹 Um endpoint `Post` para **gerenciamento de contas**
- 🔹 Um endpoint `Post` para **gerenciamento de transações**

### Requisitos:
- Criar e fornecer informações sobre a conta
- Processar transações corretamente
- Aplicar boas práticas de desenvolvimento, versionamento e organização de código

---

## 🚀 Tecnologias e Ferramentas

- **Linguagem:** PHP `^8.2` (Usei a versão `8.4`)
- **Framework:** Laravel 12
- **Banco de dados:** MySQL
- **Containers:** Docker
- **Documentação de API:** Swagger
- **Testes:** PHPUnit
- **HTTP Helpers:** http-message-util

### 📦 Bibliotecas
- [`phpunit`](https://phpunit.de/index.html)
- [`http-message-util`](https://github.com/php-fig/http-message-util)
- [`laravel-swagger-docs`](https://github.com/Mezatsong/laravel-swagger-docs)

---

### 📁 Estrutura do projeto:
`/app/DTOs:` DTOs (Data Transfer Objects)

`/app/Enums:` Enums

`/app/Exceptions:` Exceções

`/app/Factories:` Factories

`/app/Repositories:` Repositórios

`/app/Services:` Serviços

`/app/Strategies:` Estratégias

---

## 🛠️ Como Rodar o Projeto

### ⚙️ Requisitos:
- Docker e Docker Compose instalados
- PHP ^8.2 instalado
- MySQL instalado

### 🧭 Passo a Passo

- Clone Repositório
```sh
git clone -b https://github.com/Pierre-Mendes/desafio-tecnico-gerenciamento-contas.git desafio-tecnico-gerenciamento-contas
```
```sh
cd desafio-tecnico-gerenciamento-contas
```

- Suba os containers do projeto
```sh
docker-compose up -d
```

- Crie o Arquivo .env
```sh
cp .env.example .env
```

- Para acessar o container docker execute:
```sh
docker exec -it desafio-tecnico-gerenciamento-contas_app_1 bash
```

- No terminal instale as dependências do projeto
```sh
composer install
```

- Gere a key do projeto Laravel
```sh
php artisan key:generate
````

- Dentro do `container docker`, execute as migrações para configurar o banco de dados:
```sh
php artisan migrate
```
- Dentro do `container docker`, ajuste as permissões do diretório `storage/` e `bootstrap/cache/`:
```sh
chmod 777 -Rf storage/ bootstrap/cache
```

## 🌐 Acesso
- API: http://localhost:8000/api

- PhpMyAdmin: http://localhost:8080

## ✅ Testes
Para rodar os testes automatizados com PHPUnit:
```sh
php artisan test
```
## 📄 Documentação da API
- ["Swagger UI"](http://localhost:8000/docs/#/)
- ["Collections Postman"](https://documenter.getpostman.com/view/18126995/2sB2cYeMRa#3d6d410f-0496-41d4-a13b-66f7c4241a7d)

# 👨‍💻 Autor
Feito por [`Pierre Mendes Salatiel`](https://github.com/Pierre-Mendes)
