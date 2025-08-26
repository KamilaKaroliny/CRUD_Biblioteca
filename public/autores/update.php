<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$id = intval($_GET['id']);
$dados = $conn->query("SELECT * FROM autores WHERE id_autor = $id")->fetch_assoc();
?>

<div class="container mt-4">
    <h2 class="mb-4">Editar autor</h2>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" value="<?= $dados['nome'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="nacionalidade" class="form-label">Nacionalidade</label>
            <input type="text" name="nacionalidade" id="nacionalidade" value="<?= $dados['nacionalidade'] ?>" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="ano_nascimento" class="form-label">Ano nascimento</label>
            <input type="number" name="ano_nascimento" id="ano_nascimento" value="<?= $dados['ano_nascimento'] ?>" class="form-control" required>
        </div>

        <div class="col-12">
            <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
            <a href="read.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = intval($_POST['ano_nascimento']);

    $sql = "UPDATE autores 
            SET nome='$nome', nacionalidade='$nacionalidade', ano_nascimento=$ano_nascimento
            WHERE id_autor=$id";

    if ($conn->query($sql)) {
        header("Location: read.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Erro: " . $conn->error . "</div>";
    }
}
?>