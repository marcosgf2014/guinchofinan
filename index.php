<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<?php
// Buscar receitas e despesas mensais a partir de 2024
$dadosGrafico = [];
$labelsGrafico = [];
$entradasGrafico = [];
$saidasGrafico = [];
$sqlGrafico = "SELECT DATE_FORMAT(data, '%Y-%m') as mes, tipo, SUM(valor) as total FROM financeiro WHERE data >= '2024-01-01' GROUP BY mes, tipo ORDER BY mes ASC";
$resG = $conn->query($sqlGrafico);
if ($resG) {
    while($row = $resG->fetch_assoc()) {
        $mes = $row['mes'];
        if (!isset($dadosGrafico[$mes])) {
            $dadosGrafico[$mes] = ['entrada'=>0, 'saida'=>0];
        }
        $dadosGrafico[$mes][$row['tipo']] = (float)$row['total'];
    }
}
foreach ($dadosGrafico as $mes => $valores) {
    $labelsGrafico[] = $mes;
    $entradasGrafico[] = $valores['entrada'];
    $saidasGrafico[] = $valores['saida'];
}
?>
<div class="dashboard-graph" style="margin:24px 0 32px 0; background:#fff; border-radius:12px; box-shadow:0 2px 8px #0001; padding:24px;">
    <h2 style="font-size:1.2rem; font-weight:600; margin-bottom:16px;">Gráfico Financeiro (Entradas e Saídas)</h2>
    <canvas id="graficoFinanceiro" height="60"></canvas>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('graficoFinanceiro').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labelsGrafico); ?>,
            datasets: [
                {
                    label: 'Entradas',
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1,
                    data: <?php echo json_encode($entradasGrafico); ?>,
                },
                {
                    label: 'Saídas',
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1,
                    data: <?php echo json_encode($saidasGrafico); ?>,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                        }
                    }
                }
            }
        }
    });
});
</script>
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
                    <strong><?php echo htmlspecialchars(date('d/m/Y', strtotime($lanc['data']))); ?></strong> -
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
