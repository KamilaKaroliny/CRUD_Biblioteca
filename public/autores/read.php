<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

// Filtro por nome
$nomeFiltro = $_GET['nome'] ?? '';

// Paginação
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$itens_por_pagina = 10;
$offset = ($pagina - 1) * $itens_por_pagina;

// Contagem
$sqlCount = "SELECT COUNT(*) as total FROM autores WHERE 1=1";
$paramsCount = [];
$typesCount = "";

if (!empty($nomeFiltro)) {
    $sqlCount .= " AND nome LIKE ?";
    $paramsCount[] = "%$nomeFiltro%";
    $typesCount .= "s";
}

$stmtCount = $conn->prepare($sqlCount);
if ($paramsCount) $stmtCount->bind_param($typesCount, ...$paramsCount);
$stmtCount->execute();
$total_registros = $stmtCount->get_result()->fetch_assoc()['total'];
$total_paginas = max(1, ceil($total_registros / $itens_por_pagina));

// Consulta principal
$sql = "SELECT * FROM autores WHERE 1=1";
$params = [];
$types = "";

if (!empty($nomeFiltro)) {
    $sql .= " AND nome LIKE ?";
    $params[] = "%$nomeFiltro%";
    $types .= "s";
}

$sql .= " ORDER BY id_autor DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $itens_por_pagina;
$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="d-flex justify-content-between mb-3">
    <h2>Autores</h2>
    <a class="btn btn-success" href="create.php">➕ Adicionar Autor</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="nome" value="<?= htmlspecialchars($nomeFiltro) ?>" class="form-control" placeholder="Filtrar por nome">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>
</form>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Nacionalidade</th>
            <th>Ano Nascimento</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_autor'] ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['nacionalidade']) ?></td>
                    <td><?= htmlspecialchars($row['ano_nascimento']) ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="update.php?id=<?= $row['id_autor'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $row['id_autor'] ?>" onclick="return confirm('Deseja excluir este autor?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Nenhum autor encontrado.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paginação -->
<nav>
    <ul class="pagination">
        <?php for($i=1; $i<=$total_paginas; $i++): ?>
            <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                <a class="page-link" href="?pagina=<?= $i ?>&nome=<?= urlencode($nomeFiltro) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include('../../includes/footer.php'); ?>
<link rel="stylesheet" href="../../style/style.css">