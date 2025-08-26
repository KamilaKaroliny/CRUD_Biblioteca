<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 
?>

<div class="container mt-4">
    <h2 class="mb-4">Cadastrar Autor</h2>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="nacionalidade" class="form-label">Nacionalidade</label>
            <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="ano_nascimento" class="form-label">Ano nascimento</label>
            <input type="number" name="ano_nascimento" id="ano_nascimento" class="form-control" required>
        </div>

        <div class="col-12">
            <button type="submit" name="salvar" class="btn btn-success">Salvar</button>
            <a href="read.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = intval($_POST['ano_nascimento']);

    $sql = "INSERT INTO autores (nome, nacionalidade, ano_nascimento)
            VALUES ('$nome', '$nacionalidade', $ano_nascimento)";

    if ($conn->query($sql)) {
        header("Location: read.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Erro: " . $conn->error . "</div>";
    }
}
?>