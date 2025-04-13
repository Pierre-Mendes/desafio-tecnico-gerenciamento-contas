<img src="https://github.com/Pierre-Mendes/First-Challenge-Bootcamp-Java-DIO/assets/63386178/da4a13ca-375c-4546-99e5-034786980e47" alt="Banner" style="width:100%;" />

---

# 🧪 Teste Técnico – Objective

![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-finalizado-brightgreen)

Este repositório contém a solução para o **teste técnico proposto pela empresa Objective**, com o objetivo de demonstrar habilidades em:

> **PHP · Laravel · SQL · POO · Design Patterns · Boas práticas de desenvolvimento**

---

## 🎯 Desafio

Criação de dois endpoints para um sistema de gerenciamento bancário:

- 🔹 Um endpoint para **gerenciamento de contas**
- 🔹 Um endpoint para **gerenciamento de transações**

### Requisitos:
- Criar e fornecer informações sobre a conta
- Processar transações corretamente
- Aplicar boas práticas de desenvolvimento, versionamento e organização de código

---

## 🚀 Tecnologias e Ferramentas

- **Linguagem:** PHP `^8.2`
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
- PHP 8.2 instalado
- MySQL instalado

### 🧭 Passo a Passo

- Clone Repositório
```sh
git clone -b https://github.com/Pierre-Mendes/desafio-tecnico-objective.git desafio-tecnico-objective
```
```sh
cd desafio-tecnico-objective
```

- Suba os containers do projeto
```sh
docker-compose up -d
```

- Crie o Arquivo .env
```sh
cp .env.example .env
```

- Acesse o container app
```sh
docker-compose exec app bash
```

- Instale as dependências do projeto
```sh
composer install
```

- Gere a key do projeto Laravel
```sh
php artisan key:generate
````

- Rodar as migrations
```sh
php artisan migrate
```

## 🌐 Acesso
API: http://localhost:8000

PhpMyAdmin: http://localhost:8080

## ✅ Testes
Para rodar os testes automatizados com PHPUnit:
```sh
php artisan test
```
## 📄 Documentação da API
Swagger UI: http://localhost:8000/docs/#/

# 👨‍💻 Autor
Feito por [`Pierre Mendes Salatiel`](https://github.com/Pierre-Mendes)