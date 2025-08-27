                                        Biblioteca em CRUD.

ㅤ

                    Como rodar no XAMPP

1. Baixe e instale o XAMPP;
2. Copie a pasta do projeto para o diretório:

C:\xampp\htdocs\

3. Abra o XAMPP Control Panel e inicie os serviços:

Apache;
MySQL.

                    Como configurar a conexão com o banco

Abra o arquivo:

include/db.php;
Configure as credenciais de acordo com seu MySQL.

                    Como executar os scripts

Abra o phpMyAdmin pelo XAMPP:
http://localhost/phpmyadmin

Crie um banco chamado biblioteca.

Importe o arquivo SQL que está na pasta db/db.sql.

Isso criará as tabelas necessárias para Autores, Livros, Leitores e Empréstimos.

                    Funcionalidades

Autores

Criar: adicionar novo autor.
Listar: ver todos os autores com filtro por nome.
Editar: atualizar dados do autor.
Excluir: remover autor (com confirmação).

Livros

Criar: cadastrar novo livro (com vínculo ao autor).
Listar: ver todos os livros com filtros.
Editar: atualizar dados do livro.
Excluir: remover livro.

Leitores

Criar: adicionar novo leitor.
Listar: ver todos os leitores com filtro.
Editar: atualizar informações do leitor.
Excluir: remover leitor.

Empréstimos

Criar: registrar um empréstimo de livro para um leitor.
Listar: ver todos os empréstimos (com filtros e paginação).
Editar: atualizar informações do empréstimo.
Excluir: remover empréstimo.

                    Créditos

Este projeto foi desenvolvido pela aluna: kamilakaroliny. 
Projetado pelo nosso professor de desenvolvimento de sistemas Ícaro Botelho. Livre para estudos e dicas de melhoria.