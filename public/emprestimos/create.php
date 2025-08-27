<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livro = $_POST['id_livro'];
    $id_leitor = $_POST['id_leitor'];
    $data_emprestimo = $_POST['data_emprestimo'];

    // Validação 1: verificar se o livro já está emprestado (sem data de devolução)
    $checkLivro = $conn->query("SELECT * FROM emprestimos WHERE id_livro = $id_livro AND data_devolucao IS NULL");
    if ($checkLivro->num_rows > 0) {
        $msg = "❌ Este livro já está emprestado!";
    } else {
        // Validação 2: limite de 3 empréstimos ativos por leitor
        $checkLeitor = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE id_leitor = $id_leitor AND data_devolucao IS NULL");
        $row = $checkLeitor->fetch_assoc();
        if ($row['total'] >= 3) {
            $msg = "❌ Este leitor já possui 3 empréstimos ativos!";
        } else {
            $sql = "INSERT INTO emprestimos (id_livro, id_leitor, data_emprestimo) 
                    VALUES ($id_livro, $id_leitor, '$data_emprestimo')";
            if ($conn->query($sql)) {
                header("Location: read.php");
                exit;
            } else {
                $msg = "Erro: " . $conn->error;
            }
        }
    }
}
?>

<div class="container mt-4">
    <h2>Novo Empréstimo</h2>

    <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Livro</label>
            <select name="id_livro" class="form-control" required>
                <option value="">Selecione</option>
                <?php
                $livros = $conn->query("SELECT * FROM livros ORDER BY titulo");
                while($l = $livros->fetch_assoc()) {
                    echo "<option value='{$l['id_livro']}'>{$l['titulo']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Leitor</label>
            <select name="id_leitor" class="form-control" required>
                <option value="">Selecione</option>
                <?php
                $leitores = $conn->query("SELECT * FROM leitores ORDER BY nome");
                while($r = $leitores->fetch_assoc()) {
                    echo "<option value='{$r['id_leitor']}'>{$r['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Data do Empréstimo</label>
            <input type="date" name="data_emprestimo" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="read.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>