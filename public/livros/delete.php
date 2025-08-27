<?php 
include('../../includes/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("DELETE FROM livros WHERE id_livro = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: read.php?msg=Livro excluído com sucesso!");
    exit;
} else {
    // Se houver FK (ex.: empréstimos), o MySQL pode retornar erro 1451
    $msg = "Não foi possível excluir. Verifique se existem empréstimos vinculados a este livro.";
    header("Location: read.php?msg=" . urlencode($msg));
    exit;
}