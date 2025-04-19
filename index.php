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
$ultimosClientes = [];
$resQtd = $conn->query("SELECT COUNT(*) as total FROM clientes");
if ($resQtd && $rowQtd = $resQtd->fetch_assoc()) {
    $qtdClientes = (int)$rowQtd['total'];
}
$resUltimos = $conn->query("SELECT nome FROM clientes ORDER BY id DESC LIMIT 5");
if ($resUltimos && $resUltimos->num_rows > 0) {
    while ($row = $resUltimos->fetch_assoc()) {
        $ultimosClientes[] = $row['nome'];
    }
}
?>
<span class="card-value" id="clientes-count"><?php echo $qtdClientes; ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-car"></i></div>
                <div class="card-info">
                    <span class="card-title">Veículos</span>
                    <?php
$qtdVeiculos = 0;
$ultimosVeiculos = [];
$resQtdV = $conn->query("SELECT COUNT(*) as total FROM veiculos");
if ($resQtdV && $rowQtdV = $resQtdV->fetch_assoc()) {
    $qtdVeiculos = (int)$rowQtdV['total'];
}
$resUltimosV = $conn->query("SELECT placa, modelo FROM veiculos ORDER BY id DESC LIMIT 5");
if ($resUltimosV && $resUltimosV->num_rows > 0) {
    while ($row = $resUltimosV->fetch_assoc()) {
        $ultimosVeiculos[] = $row;
    }
}
?>
<span class="card-value" id="veiculos-count"><?php echo $qtdVeiculos; ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-coins"></i></div>
                <div class="card-info">
                    <span class="card-title">Saldo</span>
                    <?php
$saldo = 0.00;
$ultimosLancamentos = [];
$resResumo = $conn->query("SELECT tipo, SUM(valor) as total FROM financeiro WHERE data >= '2024-01-01' GROUP BY tipo");
$entradas = 0.00;
$saidas = 0.00;
if ($resResumo) {
    while($r = $resResumo->fetch_assoc()) {
        if ($r['tipo'] == 'entrada') $entradas += $r['total'];
        if ($r['tipo'] == 'saida') $saidas += $r['total'];
    }
}
$saldo = $entradas - $saidas;
$resUltimosLanc = $conn->query("SELECT data, descricao, valor, tipo FROM financeiro WHERE data >= '2024-01-01' ORDER BY data DESC, id DESC LIMIT 5");
if ($resUltimosLanc && $resUltimosLanc->num_rows > 0) {
    while ($row = $resUltimosLanc->fetch_assoc()) {
        $ultimosLancamentos[] = $row;
    }
}
?>
<span class="card-value" id="saldo">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></span>
                </div>
            </div>
        </div>
        <div class="dashboard-sections">
            <section>
                <h2>Últimos Clientes</h2>
                <div id="ultimos-clientes">
    <?php if (count($ultimosClientes) > 0): ?>
        <ul style="margin-bottom:0; padding-left:1.2em;">
            <?php foreach ($ultimosClientes as $nome): ?>
                <li><?php echo htmlspecialchars($nome); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        Nenhum cliente cadastrado.
    <?php endif; ?>
</div>
            </section>
            <section>
                <h2>Últimos Veículos</h2>
                <div id="ultimos-veiculos">
    <?php if (count($ultimosVeiculos) > 0): ?>
        <ul style="margin-bottom:0; padding-left:1.2em;">
            <?php foreach ($ultimosVeiculos as $veiculo): ?>
                <li><?php echo htmlspecialchars($veiculo['placa']) . ' - ' . htmlspecialchars($veiculo['modelo']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        Nenhum veículo cadastrado.
    <?php endif; ?>
</div>
            </section>
            <section>
                <h2>Movimentação Financeira</h2>
                <div id="ultimos-financeiro">
    <?php if (count($ultimosLancamentos) > 0): ?>
        <ul style="margin-bottom:0; padding-left:1.2em;">
            <?php foreach ($ultimosLancamentos as $lanc): ?>
                <li>
                    <span><?php echo htmlspecialchars(date('d/m/Y', strtotime($lanc['data']))); ?></span> -
                    <?php echo htmlspecialchars($lanc['descricao']); ?>
                    (<?php echo $lanc['tipo'] == 'entrada' ? '+' : '-'; ?>R$ <?php echo number_format($lanc['valor'], 2, ',', '.'); ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        Nenhum lançamento cadastrado.
    <?php endif; ?>
</div>
            </section>
        </div>
    </main>
    <script src="assets/dashboard.js"></script>
</body>
</html>
