<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 

// --- Filtros ---
$tituloFiltro = $_GET['titulo'] ?? '';
$generoFiltro = $_GET['genero'] ?? '';
$autorFiltro  = $_GET['autor']  ?? '';
$anoFiltro    = $_GET['ano']    ?? '';

// --- Paginação ---
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$itens_por_pagina = 10;
$offset = ($pagina - 1) * $itens_por_pagina;

// --- (com filtros) ---
$sqlCount = "SELECT COUNT(*) AS total
             FROM livros l
             LEFT JOIN autores a ON l.id_autor = a.id_autor
             WHERE 1=1";
$paramsCount = [];
$typesCount  = "";

if (!empty($tituloFiltro)) { $sqlCount .= " AND l.titulo LIKE ?";      $paramsCount[] = "%$tituloFiltro%"; $typesCount .= "s"; }
if (!empty($generoFiltro)) { $sqlCount .= " AND l.genero LIKE ?";      $paramsCount[] = "%$generoFiltro%"; $typesCount .= "s"; }
if (!empty($autorFiltro))  { $sqlCount .= " AND a.nome LIKE ?";        $paramsCount[] = "%$autorFiltro%";  $typesCount .= "s"; }
if (!empty($anoFiltro))    { $sqlCount .= " AND l.ano_publicacao = ?"; $paramsCount[] = (int)$anoFiltro;   $typesCount .= "i"; }

$stmtCount = $conn->prepare($sqlCount);
if ($paramsCount) { $stmtCount->bind_param($typesCount, ...$paramsCount); }
$stmtCount->execute();
$total_registros = $stmtCount->get_result()->fetch_assoc()['total'] ?? 0;
$total_paginas = max(1, ceil($total_registros / $itens_por_pagina));


//--- CONSULTA (com filtros) ---

$sql = "SELECT l.id_livro, l.titulo, l.genero, l.ano_publicacao, a.nome AS autor_nome
        FROM livros l
        LEFT JOIN autores a ON l.id_autor = a.id_autor
        WHERE 1=1";
$params = [];
$types  = "";

if (!empty($tituloFiltro)) { $sql .= " AND l.titulo LIKE ?";      $params[] = "%$tituloFiltro%"; $types .= "s"; }
if (!empty($generoFiltro)) { $sql .= " AND l.genero LIKE ?";      $params[] = "%$generoFiltro%"; $types .= "s"; }
if (!empty($autorFiltro))  { $sql .= " AND a.nome LIKE ?";        $params[] = "%$autorFiltro%";  $types .= "s"; }
if (!empty($anoFiltro))    { $sql .= " AND l.ano_publicacao = ?"; $params[] = (int)$anoFiltro;   $types .= "i"; }

$sql .= " ORDER BY l.id_livro DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $itens_por_pagina;
$types   .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Livros</h2>
        <a class="btn btn-success" href="create.php">Cadastrar Livro</a>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <!-- Filtros -->
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="titulo" class="form-control" placeholder="Filtrar por título"
                   value="<?= htmlspecialchars($tituloFiltro) ?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="genero" class="form-control" placeholder="Gênero"
                   value="<?= htmlspecialchars($generoFiltro) ?>">
        </div>
        <div class="col-md-3">
            <input type="text" name="autor" class="form-control" placeholder="Autor"
                   value="<?= htmlspecialchars($autorFiltro) ?>">
        </div>
        <div class="col-md-2">
            <input type="number" name="ano" class="form-control" placeholder="Ano"
                   value="<?= htmlspecialchars($anoFiltro) ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">Filtrar</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_livro'] ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['genero']) ?></td>
                    <td><?= htmlspecialchars($row['ano_publicacao']) ?></td>
                    <td><?= htmlspecialchars($row['autor_nome'] ?? '—') ?></td>
                    <td>
                        <a href="update.php?id=<?= $row['id_livro'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="delete.php?id=<?= $row['id_livro'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Deseja realmente excluir o livro <?= htmlspecialchars($row['titulo']) ?>?')">
                           Excluir
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">Nenhum livro encontrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginação -->
    <nav>
        <ul class="pagination">
            <?php for($i=1; $i<=$total_paginas; $i++): ?>
                <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="?pagina=<?= $i ?>
                       &titulo=<?= urlencode($tituloFiltro) ?>
                       &genero=<?= urlencode($generoFiltro) ?>
                       &autor=<?= urlencode($autorFiltro) ?>
                       &ano=<?= urlencode($anoFiltro) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<?php include('../../includes/footer.php'); ?>
<link rel="stylesheet" href="../../style/style.css">