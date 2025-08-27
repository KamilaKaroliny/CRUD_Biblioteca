<?php 
include('../../includes/db.php');
include('../../includes/header.php'); 
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Leitores</h2>
        <a class="btn btn-success" href="create.php">Cadastrar Leitor</a>
    </div>

    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="filtro" placeholder="Buscar por nome" value="<?php echo isset($_GET['filtro']) ? $_GET['filtro'] : ''; ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $limite = 10;
            $inicio = ($pagina - 1) * $limite;
            $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

            $sql = "SELECT * FROM leitores 
                    WHERE nome LIKE '%$filtro%' 
                    ORDER BY id_leitor DESC 
                    LIMIT $inicio, $limite";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_leitor']}</td>
                    <td>{$row['nome']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['telefone']}</td>
                    <td>
                        <a href='update.php?id={$row['id_leitor']}' class='btn btn-sm btn-warning'>Editar</a>
                        <a href='delete.php?id={$row['id_leitor']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Deseja realmente excluir o leitor {$row['nome']}?')\">Excluir</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Paginação -->
    <nav>
        <ul class="pagination">
            <?php
            $total = $conn->query("SELECT COUNT(*) as total FROM leitores WHERE nome LIKE '%$filtro%'")->fetch_assoc()['total'];
            $totalPaginas = ceil($total / $limite);

            for ($i = 1; $i <= $totalPaginas; $i++) {
                $active = $i == $pagina ? 'active' : '';
                echo "<li class='page-item $active'>
                        <a class='page-link' href='?pagina=$i&filtro=$filtro'>$i</a>
                      </li>";
            }
            ?>
        </ul>
    </nav>
</div>

<?php include('../../includes/footer.php'); ?>