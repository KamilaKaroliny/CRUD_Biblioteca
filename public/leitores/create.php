<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO leitores (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Leitor cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Cadastrar Leitor</h2>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="read.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php include('../../includes/footer.php'); ?>