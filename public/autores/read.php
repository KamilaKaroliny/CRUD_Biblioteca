<?php
include('../../includes/db.php');
include('../../includes/header.php');

// Paginação
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$itens_por_pagina = 10;
$offset = ($pagina - 1) * $itens_por_pagina;

// Filtro por nome
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';
$sql = "SELECT * FROM autores WHERE 1";

if (!empty($filtro)) {
    $sql .= " AND nome LIKE '%$filtro%'";
}

$total_result = $conn->query("SELECT COUNT(*) AS total FROM autores WHERE nome LIKE '%$filtro%'")->fetch_assoc();
$total = $total_result['total'];
$total_paginas = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Autores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Autores</h2>
        <form method="GET" class="mb-3">
            <input type="text" name="filtro" placeholder="Buscar por nome" value="<?= htmlspecialchars($filtro) ?>">
            <button class="btn btn-primary">Filtrar</button>
            <a href="create.php" class="btn btn-success">Novo Autor</a>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Nacionalidade</th>
                    <th>Ano de Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($autor = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $autor['id_autor'] ?></td>
                        <td><?= $autor['nome'] ?></td>
                        <td><?= $autor['nacionalidade'] ?></td>
                        <td><?= $autor['ano_nascimento'] ?></td>
                        <td>
                            <a href="update.php?id=<?= $autor['id_autor'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete.php?id=<?= $autor['id_autor'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination">
                <?php for($i=1; $i<=$total_paginas; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&filtro=<?= $filtro ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>