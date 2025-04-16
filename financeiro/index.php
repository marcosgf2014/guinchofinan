<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Financeiro | Guincho</title>
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
            <a href="../veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="index.php" class="active"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Gerenciador Financeiro</h1>
        <section>
            <form class="form-financeiro" method="post" action="salvar.php">
                <input type="text" name="cliente" placeholder="Cliente">
                <input type="text" name="veiculo" placeholder="Veículo">
                <input type="date" name="data" placeholder="Data">
                <input type="number" step="0.01" name="valor" placeholder="Valor">
                <input type="text" name="descricao" placeholder="Descrição">
                <select name="tipo">
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
                <button type="submit" class="btn-novo"><i class="fas fa-plus"></i> Salvar</button>
            </form>
        </section>
        <section>
            <h2>Lançamentos Financeiros</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Veículo</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../db.php';
                    $sql = "SELECT f.*, c.nome as cliente_nome, v.placa as veiculo_placa FROM financeiro f
                            LEFT JOIN clientes c ON f.cliente_id = c.id
                            LEFT JOIN veiculos v ON f.veiculo_id = v.id
                            ORDER BY f.data DESC, f.id DESC";
                    $res = $conn->query($sql);
                    if ($res && $res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['cliente_nome']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['veiculo_placa']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['data']) . '</td>';
                            echo '<td>' . number_format($row['valor'], 2, ',', '.') . '</td>';
                            echo '<td>' . htmlspecialchars($row['tipo']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['descricao']) . '</td>';
                            echo '<td>';
                            echo '<a href="#" class="btn-editar"><i class="fas fa-edit"></i></a>';
                            echo '<a href="#" class="btn-excluir"><i class="fas fa-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">Nenhum lançamento cadastrado ainda.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
