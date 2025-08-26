<?php 
include('../../includes/db.php');
include('../../includes/header.php');

$id = intval($_GET['id']);

$sql = "DELETE FROM autores WHERE id_autor = $id";
if ($conn->query($sql)) {
    echo "Autor excluído!";
} else {
    echo "Erro: " . $conn->error;
}
?>
<a href="read.php">Voltar para lista</a>