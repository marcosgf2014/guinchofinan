<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Veículos | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-title">Guincho</div>
        <nav>
            <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="../clientes/index.php"><i class="fas fa-users"></i> Clientes</a>
            <a href="index.php" class="active"><i class="fas fa-car"></i> Veículos</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Cadastro de Veículos</h1>
        <section>
            <form class="form-veiculos" method="post" action="salvar.php">
                <input type="text" name="placa" placeholder="Placa" required>
                <input type="text" name="modelo" placeholder="Modelo">
                <input type="text" name="cor" placeholder="Cor">
                <input type="text" name="cliente" placeholder="Cliente">
                <button type="submit" class="btn-novo"><i class="fas fa-plus"></i> Salvar</button>
            </form>
        </section>
        <section>
            <h2>Lista de Veículos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Cor</th>
                        <th>Cliente</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../db.php';
                    $sql = "SELECT v.*, c.nome as cliente_nome FROM veiculos v LEFT JOIN clientes c ON v.cliente_id = c.id ORDER BY v.id DESC";
                    $res = $conn->query($sql);
                    if ($res && $res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['placa']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['cor']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['cliente_nome']) . '</td>';
                            echo '<td>';
                            echo '<a href="#" class="btn-editar"><i class="fas fa-edit"></i></a>';
                            echo '<a href="#" class="btn-excluir"><i class="fas fa-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Nenhum veículo cadastrado ainda.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
