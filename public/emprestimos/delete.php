<?php 
include('../../includes/db.php');

$id = $_GET['id'];

$sql = "DELETE FROM emprestimos WHERE id_emprestimo = $id";
$conn->query($sql);

header("Location: read.php");
exit;
?>