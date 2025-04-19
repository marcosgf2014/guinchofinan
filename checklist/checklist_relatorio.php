<?php
require_once '../db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo '<div style="padding:2rem;text-align:center;color:#b00;font-size:1.2rem;">Checklist não encontrado.</div>';
    exit;
}

$sql = "SELECT * FROM checklist WHERE id = $id";
$res = $conn->query($sql);
if (!$res || $res->num_rows === 0) {
    echo '<div style="padding:2rem;text-align:center;color:#b00;font-size:1.2rem;">Checklist não encontrado.</div>';
    exit;
}
$row = $res->fetch_assoc();

function campo($label, $valor, $icon) {
    return '<div class="d-flex align-items-center mb-2"><span class="me-2">' . $icon . '</span><span class="fw-bold">' . $label . ':</span> <span class="ms-2">' . htmlspecialchars($valor) . '</span></div>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório do Checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafb; }
        .relatorio-card { max-width: 700px; margin: 2rem auto; background: #fff; border-radius: 1.25rem; box-shadow: 0 2px 16px #0001; padding: 2rem; }
        .relatorio-header { border-bottom: 2px solid #eee; margin-bottom: 1.5rem; padding-bottom: 1rem; display: flex; align-items: center; gap: 1rem; }
        .relatorio-header i { font-size: 2.2rem; color: #0d6efd; }
        .relatorio-title { font-size: 1.7rem; font-weight: bold; }
        .relatorio-section-title { font-size: 1.1rem; color: #0d6efd; margin-top: 1.5rem; margin-bottom: .6rem; font-weight: 600; }
        .campo-valor { font-family: 'Fira Mono', monospace; }
        @media print {
            body { background: #fff !important; }
            aside.sidebar, nav, .btn, .text-end.mt-4, .main-content > h1, .main-content > .row.mb-4, .main-content > .alert { display: none !important; }
            .main-content.container.py-4, .relatorio-card { box-shadow: none !important; margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-title">Guincho</div>
        <nav>
            <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="../clientes/index.php"><i class="fas fa-users"></i> Clientes</a>
            <a href="../veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="index.php" class="active"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
            <a href="../relatorios/index.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
    <div class="relatorio-card">
        <div class="relatorio-header">
            <i class="fas fa-file-alt" style="color:#2196f3;"></i>
            <span class="relatorio-title">Relatório do Checklist</span>
            <span class="ms-auto text-muted"><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($row['entrada'])) ?></span>
        </div>
        <?php
        echo campo('Cliente', $row['cliente'], '<i class="fas fa-user"></i>');
        echo campo('Veículo', $row['veiculo'], '<i class="fas fa-car"></i>');
        echo campo('Origem', $row['origem'], '<i class="fas fa-map-marker-alt"></i>');
        echo campo('Destino', $row['destino'], '<i class="fas fa-location-arrow"></i>');
        echo campo('Quilometragem', $row['quilometragem'], '<i class="fas fa-tachometer-alt"></i>');
        echo campo('Combustível', $row['combustivel'], '<i class="fas fa-gas-pump"></i>');
        ?>
        <?php if (!empty($row['itens'])): ?>
        <div class="relatorio-section-title"><i class="fas fa-clipboard-list"></i> Itens do Checklist</div>
        <div class="mb-2" style="white-space:pre-line;"><i class="fas fa-check-double text-success me-2"></i><?= nl2br(htmlspecialchars($row['itens'])) ?></div>
<?php endif; ?>

        <div class="relatorio-section-title"><i class="fas fa-cogs"></i> Detalhes do Veículo</div>
        <div class="row mb-2">
            <div class="col-md-6">
                <?= campo('Pneus Dianteiros', $row['pneus_dianteiros'] ?? '', '<i class="fas fa-dot-circle"></i>') ?>
                <?= campo('Pneus Traseiros', $row['pneus_traseiros'] ?? '', '<i class="fas fa-dot-circle"></i>') ?>
                <?= campo('Rodas Dianteiras', $row['rodas_dianteiras'] ?? '', '<i class="fas fa-circle"></i>') ?>
                <?= campo('Rodas Traseiras', $row['rodas_traseiras'] ?? '', '<i class="fas fa-circle"></i>') ?>
            </div>
            <div class="col-md-6">
                <div class="fw-bold mb-1"><i class="fas fa-toolbox"></i> Acessórios</div>
                <?php $acessorios = ['calotas','retrovisores','palhetas','triangulo','macaco'];
                foreach ($acessorios as $a) {
                    if (!empty($row[$a])) {
                        echo '<span class="badge me-1 mb-1" style="background:#e8fae5;color:#32a852;border:1px solid #222;font-size:1rem;"><i class="fas fa-check"></i> '.ucfirst(str_replace('_',' ',$a)).'</span>';
                    } else {
                        echo '<span class="badge text-danger me-1 mb-1" style="background:#ffe5e9;border:1px solid #222;font-size:1rem;color:#e74c3c;"><i class="fas fa-times"></i> '.ucfirst(str_replace('_',' ',$a)).'</span>';
                    }
                } ?>
                <div class="fw-bold mt-2 mb-1"><i class="fas fa-chair"></i> Interior</div>
                <?php $interior = ['bancos','painel','consoles','forracao','tapetes'];
                foreach ($interior as $i) {
                    if (!empty($row[$i])) {
                        echo '<span class="badge me-1 mb-1" style="background:#e8fae5;color:#32a852;border:1px solid #222;font-size:1rem;"><i class="fas fa-check"></i> '.ucfirst($i).'</span>';
                    } else {
                        echo '<span class="badge text-danger me-1 mb-1" style="background:#ffe5e9;border:1px solid #222;font-size:1rem;color:#e74c3c;"><i class="fas fa-times"></i> '.ucfirst($i).'</span>';
                    }
                } ?>
                <div class="fw-bold mt-2 mb-1"><i class="fas fa-car-battery"></i> Outros</div>
                <?php $outros = ['bateria','chaves','documentos','som','caixa_selada'];
                foreach ($outros as $o) {
                    if (!empty($row[$o])) {
                        echo '<span class="badge me-1 mb-1" style="background:#e8fae5;color:#32a852;border:1px solid #222;font-size:1rem;"><i class="fas fa-check"></i> '.ucfirst(str_replace('_',' ',$o)).'</span>';
                    } else {
                        echo '<span class="badge text-danger me-1 mb-1" style="background:#ffe5e9;border:1px solid #222;font-size:1rem;color:#e74c3c;"><i class="fas fa-times"></i> '.ucfirst(str_replace('_',' ',$o)).'</span>';
                    }
                } ?>
            </div>
        </div>

        <?php if (!empty($row['pertences'])): ?>
            <div class="relatorio-section-title"><i class="fas fa-suitcase"></i> Pertences Deixados no Veículo</div>
            <div class="mb-2"><i class="fas fa-archive text-muted me-2"></i><?= nl2br(htmlspecialchars($row['pertences'])) ?></div>
        <?php endif; ?>
        <?php if (!empty($row['observacoes'])): ?>
            <div class="relatorio-section-title"><i class="fas fa-sticky-note"></i> Observações</div>
            <div class="mb-2"><i class="fas fa-info-circle text-warning me-2"></i><?= nl2br(htmlspecialchars($row['observacoes'])) ?></div>
        <?php endif; ?>
        <?php if (!empty($row['danos'])): ?>
            <div class="relatorio-section-title"><i class="fas fa-exclamation-triangle text-danger"></i> Danos</div>
            <div class="mb-2"><i class="fas fa-tools text-danger me-2"></i>Sim</div>
        <?php endif; ?>

        <?php if (!empty($row['fotos'])): ?>
            <div class="relatorio-section-title"><i class="fas fa-camera"></i> Fotos do Veículo</div>
            <div class="row mb-2">
                <?php foreach (explode(',', $row['fotos']) as $foto): if (trim($foto)): ?>
                <div class="col-4 col-md-3 mb-2"><img src="uploads/<?= htmlspecialchars(trim($foto)) ?>" alt="Foto" class="img-fluid rounded shadow"></div>
                <?php endif; endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($row['assinatura_cliente']) || !empty($row['assinatura_responsavel'])): ?>
            <div class="relatorio-section-title"><i class="fas fa-signature"></i> Assinaturas</div>
            <div class="row mb-2">
                <?php if (!empty($row['assinatura_cliente'])): ?>
                <div class="col-md-6 text-center">
                    <div class="fw-bold mb-1">Assinatura do Cliente</div>
                    <img src="uploads/<?= htmlspecialchars($row['assinatura_cliente']) ?>" alt="Assinatura Cliente" class="img-fluid rounded border" style="max-height:120px;">
                </div>
                <?php endif; ?>
                <?php if (!empty($row['assinatura_responsavel'])): ?>
                <div class="col-md-6 text-center">
                    <div class="fw-bold mb-1">Assinatura do Responsável</div>
                    <img src="uploads/<?= htmlspecialchars($row['assinatura_responsavel']) ?>" alt="Assinatura Responsável" class="img-fluid rounded border" style="max-height:120px;">
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="text-end mt-4">
            <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
            <button onclick="window.print()" class="btn btn-primary ms-2"><i class="fas fa-print"></i> Imprimir</button>
        </div>
    </div>
    </main>
</body>
</html>
