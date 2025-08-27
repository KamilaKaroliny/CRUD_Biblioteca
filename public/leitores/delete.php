<?php 
include('../../includes/db.php');

$id = $_GET['id'];

$sql = "DELETE FROM leitores WHERE id_leitor = $id";
if ($conn->query($sql)) {
    header("Location: read.php?msg=Leitor excluído com sucesso!");
} else {
    echo "Erro: " . $conn->error;
}
?>