<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$id = $_GET['id'];
$msg = "";

$sql = "SELECT * FROM emprestimos WHERE id_emprestimo = $id";
$result = $conn->query($sql);
$emprestimo = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_devolucao = $_POST['data_devolucao'];

    if ($data_devolucao < $emprestimo['data_emprestimo']) {
        $msg = "❌ A data de devolução não pode ser anterior à data de empréstimo.";
    } else {
        $sql = "UPDATE emprestimos SET data_devolucao = '$data_devolucao' WHERE id_emprestimo = $id";
        if ($conn->query($sql)) {
            header("Location: read.php");
            exit;
        } else {
            $msg = "Erro: " . $conn->error;
        }
    }
}
?>

<div class="container mt-4">
    <h2>Atualizar Empréstimo</h2>

    <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>

    <form method="POST">
        <p><strong>Livro:</strong> <?php echo $emprestimo['id_livro']; ?></p>
        <p><strong>Leitor:</strong> <?php echo $emprestimo['id_leitor']; ?></p>
        <p><strong>Data Empréstimo:</strong> <?php echo $emprestimo['data_emprestimo']; ?></p>

        <div class="mb-3">
            <label>Data de Devolução</label>
            <input type="date" name="data_devolucao" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="read.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>