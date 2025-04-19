<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-title">Guincho</div>
        <nav>
            <a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="clientes/index.php"><i class="fas fa-users"></i> Clientes</a>
            <a href="veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="checklist/index.php"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
            <a href="relatorios/index.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Dashboard</h1>
        <div class="cards">
            <div class="card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-info">
                    <span class="card-title">Clientes</span>
                    <?php
require_once 'db.php';
$qtdClientes = 0;
$resQtd = $conn->query("SELECT COUNT(*) as total FROM clientes");
if ($resQtd && $rowQtd = $resQtd->fetch_assoc()) {
    $qtdClientes = (int)$rowQtd['total'];
}
?>
<span class="card-value" id="clientes-count"><?= $qtdClientes ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-car"></i></div>
                <div class="card-info">
                    <span class="card-title">Veículos</span>
                    <?php
$qtdVeiculos = 0;
$resQtdVeic = $conn->query("SELECT COUNT(*) as total FROM veiculos");
if ($resQtdVeic && $rowQtdVeic = $resQtdVeic->fetch_assoc()) {
    $qtdVeiculos = (int)$rowQtdVeic['total'];
}
?>
<span class="card-value" id="veiculos-count"><?= $qtdVeiculos ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-coins"></i></div>
                <div class="card-info">
                    <span class="card-title">Saldo</span>
                    <?php
$saldo = 0;
$resSaldo = $conn->query("SELECT tipo, SUM(valor) as total FROM financeiro WHERE data >= '2024-01-01' GROUP BY tipo");
$entradas = 0;
$saidas = 0;
if ($resSaldo) {
    while($row = $resSaldo->fetch_assoc()) {
        if ($row['tipo'] == 'entrada') $entradas += $row['total'];
        if ($row['tipo'] == 'saida') $saidas += $row['total'];
    }
}
$saldo = $entradas - $saidas;
?>
<span class="card-value" id="saldo">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
                </div>
            </div>
        </div>
        <div class="dashboard-sections">
            <section>
                <h2>Últimos Clientes</h2>
                <div id="ultimos-clientes">
    <ul class="list-group">
        <?php
        $resUltimosClientes = $conn->query("SELECT nome FROM clientes ORDER BY id DESC LIMIT 5");
        if ($resUltimosClientes && $resUltimosClientes->num_rows > 0) {
            while ($row = $resUltimosClientes->fetch_assoc()) {
                echo "<li class='list-group-item'>" . htmlspecialchars($row['nome']) . "</li>";
            }
        } else {
            echo "<li class='list-group-item text-muted'>Nenhum cliente cadastrado.</li>";
        }
        ?>
    </ul>
</div>
            </section>
            <section>
                <h2>Últimos Veículos</h2>
                <div id="ultimos-veiculos">
    <ul class="list-group">
        <?php
        $resUltimosVeic = $conn->query("SELECT modelo, placa FROM veiculos ORDER BY id DESC LIMIT 5");
        if ($resUltimosVeic && $resUltimosVeic->num_rows > 0) {
            while ($row = $resUltimosVeic->fetch_assoc()) {
                $modelo = htmlspecialchars($row['modelo'] ?? '');
                $placa = htmlspecialchars($row['placa'] ?? '');
                echo "<li class='list-group-item'>" . ($modelo ? $modelo : 'Sem modelo') . " <span class='text-muted'>($placa)</span></li>";
            }
        } else {
            echo "<li class='list-group-item text-muted'>Nenhum veículo cadastrado.</li>";
        }
        ?>
    </ul>
</div>
            </section>
            <section>
                <h2>Movimentação Financeira</h2>
                <div id="ultimos-financeiro">
    <ul class="list-group">
        <?php
        $resUltimosFin = $conn->query("SELECT tipo, descricao, valor, data FROM financeiro ORDER BY data DESC, id DESC LIMIT 5");
        if ($resUltimosFin && $resUltimosFin->num_rows > 0) {
            while ($row = $resUltimosFin->fetch_assoc()) {
                $tipo = $row['tipo'] === 'entrada' ? 'Receita' : 'Despesa';
                $classe = $row['tipo'] === 'entrada' ? 'text-success' : 'text-danger';
                $valor = number_format($row['valor'], 2, ',', '.');
                $data = !empty($row['data']) ? date('d/m/Y', strtotime($row['data'])) : '';
                $descricao = htmlspecialchars($row['descricao'] ?? '');
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <span><strong class='$classe'>$tipo</strong> - $descricao <span class='text-muted'>($data)</span></span>
                    <span class='fw-bold $classe'>R$ $valor</span>
                </li>";
            }
        } else {
            echo "<li class='list-group-item text-muted'>Nenhum lançamento cadastrado.</li>";
        }
        ?>
    </ul>
</div>
            </section>
        </div>
    </main>
    <script src="assets/dashboard.js"></script>
</body>
</html>