<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano_publicacao = (int)($_POST['ano_publicacao'] ?? 0);
    $id_autor = (int)($_POST['id_autor'] ?? 0);

    // Regras de negócio: ano > 1500 e <= ano atual
    $anoAtual = (int)date('Y');
    if ($ano_publicacao < 1501 || $ano_publicacao > $anoAtual) {
        $erros[] = "O ano de publicação deve ser maior que 1500 e menor ou igual a $anoAtual.";
    }
    if ($id_autor <= 0) {
        $erros[] = "Selecione um autor.";
    }
    if ($titulo === '') {
        $erros[] = "Título é obrigatório.";
    }

    if (empty($erros)) {
        $stmt = $conn->prepare("INSERT INTO livros (titulo, genero, ano_publicacao, id_autor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $titulo, $genero, $ano_publicacao, $id_autor);
        if ($stmt->execute()) {
            header("Location: read.php?msg=Livro cadastrado com sucesso!");
            exit;
        } else {
            $erros[] = "Erro ao cadastrar: " . $conn->error;
        }
    }
}

// Carrega autores para o <select>
$autores = $conn->query("SELECT id_autor, nome FROM autores ORDER BY nome");
?>

<div class="container mt-4">
    <h2>Cadastrar Livro</h2>

    <?php if (!empty($erros)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($erros as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="row g-3 mt-1">
        <div class="col-md-6">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Gênero</label>
            <input type="text" name="genero" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Ano</label>
            <input type="number" name="ano_publicacao" class="form-control" min="1501" max="<?= date('Y') ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Autor</label>
            <select name="id_autor" class="form-select" required>
                <option value="">Selecione...</option>
                <?php while($a = $autores->fetch_assoc()): ?>
                    <option value="<?= $a['id_autor'] ?>"><?= htmlspecialchars($a['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="read.php" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>
