<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Carrega livro
$stmt = $conn->prepare("SELECT * FROM livros WHERE id_livro = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$livro = $stmt->get_result()->fetch_assoc();

if (!$livro) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Livro não encontrado.</div></div>";
    include('../../includes/footer.php'); 
    exit;
}

$erros = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano_publicacao = (int)($_POST['ano_publicacao'] ?? 0);
    $id_autor = (int)($_POST['id_autor'] ?? 0);

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
        $stmtUp = $conn->prepare("UPDATE livros 
                                  SET titulo = ?, genero = ?, ano_publicacao = ?, id_autor = ?
                                  WHERE id_livro = ?");
        $stmtUp->bind_param("ssiii", $titulo, $genero, $ano_publicacao, $id_autor, $id);
        if ($stmtUp->execute()) {
            header("Location: read.php?msg=Livro atualizado com sucesso!");
            exit;
        } else {
            $erros[] = "Erro ao atualizar: " . $conn->error;
        }
    }
}

// autores para o select
$autores = $conn->query("SELECT id_autor, nome FROM autores ORDER BY nome");
?>

<div class="container mt-4">
    <h2>Editar Livro</h2>

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
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($livro['titulo']) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Gênero</label>
            <input type="text" name="genero" class="form-control" value="<?= htmlspecialchars($livro['genero']) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Ano</label>
            <input type="number" name="ano_publicacao" class="form-control" min="1501" max="<?= date('Y') ?>"
                   value="<?= htmlspecialchars($livro['ano_publicacao']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Autor</label>
            <select name="id_autor" class="form-select" required>
                <option value="">Selecione...</option>
                <?php while($a = $autores->fetch_assoc()): ?>
                    <option value="<?= $a['id_autor'] ?>" <?= ($a['id_autor'] == $livro['id_autor']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-warning">Atualizar</button>
            <a href="read.php" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>