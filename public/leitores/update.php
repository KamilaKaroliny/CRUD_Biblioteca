<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$id = $_GET['id'];
$sql = "SELECT * FROM leitores WHERE id_leitor = $id";
$result = $conn->query($sql);
$leitor = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE leitores SET nome='$nome', email='$email', telefone='$telefone' WHERE id_leitor=$id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Leitor atualizado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Editar Leitor</h2>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?php echo $leitor['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $leitor['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?php echo $leitor['telefone']; ?>">
        </div>
        <button type="submit" class="btn btn-warning">Atualizar</button>
        <a href="read.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
