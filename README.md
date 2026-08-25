# 📝 Todo List

Sistema web de gerenciamento de tarefas desenvolvido em **PHP e MySQL**, com autenticação de usuários, gerenciamento de tarefas e upload de imagens.

O projeto foi desenvolvido como aplicação prática para estudo e evolução de conceitos de **desenvolvimento web, PHP, banco de dados, organização de código e autenticação**.

---

## 🚀 Funcionalidades

* 👤 Cadastro de usuários
* 🔐 Login e logout
* 🔒 Autenticação baseada em sessões
* ➕ Criação de tarefas
* ✏️ Edição de tarefas
* ✅ Conclusão de tarefas
* 🔄 Alteração entre tarefas pendentes e concluídas
* 🗑️ Exclusão de tarefas
* 🖼️ Upload de imagens nas tarefas
* 📱 Interface responsiva

---

## 🛠️ Tecnologias utilizadas

### Front-end

* HTML5
* CSS3
* JavaScript

### Back-end

* PHP
* PDO

### Banco de dados

* MySQL

---

## 🏗️ Estrutura do projeto

```text
todo_list/
│
├── actions/
│   ├── adicionar_tarefa.php
│   ├── cadastrar_action.php
│   ├── concluir_tarefa.php
│   ├── editar_tarefa.php
│   ├── excluir_tarefa.php
│   ├── logout.php
│   ├── processa_editar_tarefa.php
│   └── processar_login.php
│
├── assets/
│   ├── css/
│   └── js/
│
├── includes/
│   ├── autenticacao.php
│   └── conexao.php
│
├── models/
│   ├── cadastro.php
│   └── tarefas.php
│
├── public/
│   └── uploads/
│
├── uploads/
│
├── views/
│   ├── cadastro_usuario.php
│   └── lista_tarefas.php
│
├── index.php
└── todo_list.sql
```

### Organização

* **actions/** — Processamento das ações realizadas pelos usuários.
* **assets/** — Arquivos estáticos, como CSS e JavaScript.
* **includes/** — Configurações e recursos compartilhados pela aplicação.
* **models/** — Operações relacionadas aos dados e ao banco de dados.
* **views/** — Páginas e interfaces da aplicação.
* **uploads/** — Armazenamento das imagens utilizadas pelas tarefas.

---

## ⚙️ Requisitos

Para executar o projeto localmente, você precisará de:

* PHP 7.4 ou superior
* MySQL
* Apache, Nginx ou servidor embutido do PHP
* Git

---

## 📥 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/devfernandooa/todo_list.git
```

Entre no diretório:

```bash
cd todo_list
```

---

### 2. Configure o banco de dados

Crie um banco de dados MySQL e importe o arquivo:

```text
todo_list.sql
```

Depois, configure as credenciais do banco na aplicação.

> ⚠️ A configuração atual do projeto utiliza o arquivo `includes/conexao.php`. Em uma futura evolução do projeto, essa configuração será migrada para variáveis de ambiente.

---

### 3. Inicie o servidor

Utilizando o servidor embutido do PHP:

```bash
php -S localhost:8000
```

Depois acesse:

```text
http://localhost:8000
```

---

## 👤 Utilização

### Cadastro

Acesse a página de cadastro e crie uma nova conta.

### Login

Entre utilizando as credenciais cadastradas.

### Tarefas

Após o login, é possível:

* criar tarefas;
* editar tarefas;
* concluir tarefas;
* reabrir tarefas;
* excluir tarefas;
* adicionar imagens às tarefas.

---

## 🧠 Conceitos praticados

Este projeto foi desenvolvido como parte da minha evolução em desenvolvimento web e permitiu praticar conceitos como:

* PHP;
* programação para aplicações web;
* MySQL;
* PDO;
* CRUD;
* autenticação;
* sessões;
* upload de arquivos;
* organização de arquivos;
* separação entre responsabilidades;
* manipulação do DOM com JavaScript;
* desenvolvimento de interfaces responsivas.

---

## 🔐 Segurança

O projeto utiliza recursos como:

* PDO para comunicação com o banco de dados;
* autenticação por sessão;
* validação de dados;
* controle de acesso às funcionalidades autenticadas.

> Este projeto possui caráter educacional e continua em evolução. Melhorias de segurança, arquitetura e testes fazem parte do roadmap de desenvolvimento.

---

## 🗺️ Roadmap

* [ ] Melhorar a arquitetura da aplicação
* [ ] Migrar configurações sensíveis para variáveis de ambiente
* [ ] Melhorar validações
* [ ] Aprimorar segurança dos uploads
* [ ] Adicionar testes automatizados
* [ ] Melhorar tratamento de erros
* [ ] Melhorar documentação
* [ ] Evoluir a interface
* [ ] Avaliar migração futura para uma arquitetura mais estruturada

---

## 📚 Status do projeto

🟡 **Projeto de estudo e evolução contínua**

O projeto foi desenvolvido para consolidar conhecimentos de PHP, MySQL e desenvolvimento web. Algumas partes poderão ser refatoradas conforme novos conhecimentos de arquitetura, segurança e boas práticas forem adquiridos.

---

## 👨‍💻 Autor

**Fernando de Oliveira Almeida**

Desenvolvedor Web | PHP • Laravel • JavaScript

* 💼 [LinkedIn](https://www.linkedin.com/in/devfernandooa/)
* 🌐 [Portfólio](https://devfernandooa.vercel.app/)
* 📧 [Email](mailto:devfernandooa@gmail.com)

---

⭐ Se este projeto foi útil para você, considere deixar uma estrela no repositório.
