<?php 
include('../../includes/db.php');
include('../../includes/header.php');

$id = $_GET['id'];

$sql = "DELETE FROM autores WHERE id_autor=$id";
if ($conn->query($sql)) {
    echo "<div class='alert alert-success mt-3'>Autor excluído!</div>";
} else {
    echo "<div class='alert alert-danger mt-3'>Erro: " . $conn->error . "</div>";
}
?>
<a href="read.php" class="btn btn-secondary mt-3">Voltar para lista</a>