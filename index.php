<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <a href="../includes/db.php"></a>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/style.css">
    <a href="../public/autores/create.php"></a>
    <a href="../public/autores/delete.php"></a>
    <a href="../public/autores/read.php"></a>
    <a href="../public/autores/update.php"></a>
    <a href="../public/emprestimos/create.php"></a>
    <a href="../public/emprestimos/delete.php"></a>
    <a href="../public/emprestimos/read.php"></a>
    <a href="../public/emprestimos/update.php"></a>
    <a href="../public/leitores/create.php"></a>
    <a href="../public/leitores/delete.php"></a>
    <a href="../public/leitores/read.php"></a>
    <a href="../public/leitores/update.php"></a>
    <a href="../public/livros/create.php"></a>
    <a href="../public/livros/delete.php"></a>
    <a href="../public/livros/read.php"></a>
    <a href="../public/livros/update.php"></a>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/script.js"></script>
    <title>CRUD BIBLITECA</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="./assets/icons/logo.png" alt="Logo" width="40" class="d-inline-block align-text-top me-2">
            CRUD Biblioteca
        </a>
        <p id="data"></p>
    </div>
</nav><br>

<div class="container login-options text-center">
    <h1 class="mb-5">Escolha o que deseja analisar!</h1>
    <div class="d-grid gap-5 col-7 mx-auto">
        <button class="btn btn-success btn-login" onclick="window.location.href='./public/autores/read.php'">
            Autores
        </button>
        <button class="btn btn-success btn-login" onclick="window.location.href='./public/emprestimos/read.php'">
            Empréstimo
        </button>
        <button class="btn btn-success btn-login" onclick="window.location.href='./public/leitores/read.php'">
            Leitores
        </button>
        <button class="btn btn-success btn-login" onclick="window.location.href='./public/livros/read.php'">
            Livros
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('./includes/footer.php'); ?>