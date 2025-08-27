<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Empréstimos</h2>
        <a class="btn btn-success" href="create.php">➕ Novo Empréstimo</a>
    </div>

    <!-- Abas Bootstrap -->
    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a class="nav-link <?php echo (!isset($_GET['status']) || $_GET['status'] === 'ativos') ? 'active' : ''; ?>" 
               href="read.php?status=ativos">📗 Ativos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (isset($_GET['status']) && $_GET['status'] === 'concluidos') ? 'active' : ''; ?>" 
               href="read.php?status=concluidos">📕 Concluídos</a>
        </li>
    </ul>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Livro</th>
                        <th>Leitor</th>
                        <th>Data Empréstimo</th>
                        <th>Data Devolução</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $status = $_GET['status'] ?? 'ativos';

                    if ($status === 'concluidos') {
                        $sql = "SELECT e.*, l.titulo, r.nome AS leitor
                                FROM emprestimos e
                                JOIN livros l ON e.id_livro = l.id_livro
                                JOIN leitores r ON e.id_leitor = r.id_leitor
                                WHERE e.data_devolucao IS NOT NULL
                                ORDER BY e.data_emprestimo DESC";
                    } else {
                        $sql = "SELECT e.*, l.titulo, r.nome AS leitor
                                FROM emprestimos e
                                JOIN livros l ON e.id_livro = l.id_livro
                                JOIN leitores r ON e.id_leitor = r.id_leitor
                                WHERE e.data_devolucao IS NULL
                                ORDER BY e.data_emprestimo DESC";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id_emprestimo']}</td>
                                <td>{$row['titulo']}</td>
                                <td>{$row['leitor']}</td>
                                <td>{$row['data_emprestimo']}</td>
                                <td>" . ($row['data_devolucao'] ?? '—') . "</td>
                                <td>
                                    <a href='update.php?id={$row['id_emprestimo']}' class='btn btn-sm btn-warning'>Editar</a>
                                    <a href='delete.php?id={$row['id_emprestimo']}' class='btn btn-sm btn-danger' 
                                       onclick=\"return confirm('Deseja realmente excluir este empréstimo?')\">Excluir</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted'>Nenhum empréstimo encontrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>
<link rel="stylesheet" href="../../style/style.css">