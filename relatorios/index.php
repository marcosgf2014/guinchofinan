<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-title">Guincho</div>
        <nav>
            <a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="../clientes/index.php"><i class="fas fa-users"></i> Clientes</a>
            <a href="../veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="../checklist/index.php"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
            <a href="index.php" class="active"><i class="fas fa-chart-bar"></i> Relatórios</a>
            
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-chart-bar"></i> Relatórios</h1>
        <div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-filter"></i> Modos de Relatório Financeiro</h5>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item">
    <b>Relatório por Período</b>
    <form class="row g-2 mt-2" method="get" action="#" id="formPeriodo">
        <div class="col-md-5">
            <input type="date" class="form-control" name="periodo_inicio" id="periodo_inicio" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-5">
            <input type="date" class="form-control" name="periodo_fim" id="periodo_fim" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Gerar</button>
        </div>
    </form>
    <div id="relatorioPeriodo" class="mt-3"<?php if(isset($_GET['periodo_inicio']) && isset($_GET['periodo_fim']) && $_GET['periodo_inicio'] && $_GET['periodo_fim']){echo '';}else{echo ' style="display:none;"';} ?>>
        <?php
        if (isset($_GET['periodo_inicio']) && isset($_GET['periodo_fim']) && $_GET['periodo_inicio'] && $_GET['periodo_fim']) {
            require_once '../db.php';
            $inicio = $conn->real_escape_string($_GET['periodo_inicio']);
            $fim = $conn->real_escape_string($_GET['periodo_fim']);
            $sql = "SELECT * FROM financeiro WHERE data BETWEEN '$inicio' AND '$fim' ORDER BY data DESC, id DESC";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                echo '<div class="mb-2 d-flex gap-2">'
    .'<button class="btn btn-outline-success btn-sm" onclick="printTable(this)"><i class="fas fa-print"></i> Exibir</button>'
    .'<button class="btn btn-outline-danger btn-sm" onclick="exportTableToPDF(this)"><i class="fas fa-file-pdf"></i> Salvar PDF</button>'
    .'<button class="btn btn-outline-success btn-sm" onclick="exportTableToCSV(this)"><i class="fas fa-file-csv"></i> Salvar CSV</button>'
    .'<button class="btn btn-outline-secondary btn-sm" onclick="exportTableToTXT(this)"><i class="fas fa-file-alt"></i> Salvar TXT</button>'
.'</div>';
echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover align-middle shadow-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
                echo '</tr></thead><tbody>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    $tipoLabel = ($row['tipo'] === 'entrada') ? 'Receitas' : (($row['tipo'] === 'saida') ? 'Despesas' : ucfirst($row['tipo']));
echo '<td>' . htmlspecialchars($tipoLabel) . '</td>';
                    echo '<td>' . htmlspecialchars($row['categoria'] ?? '') . '</td>';
                    echo '<td>' . (!empty($row['data']) ? date('d/m/Y', strtotime($row['data'])) : '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['descricao'] ?? '') . '</td>';
                    echo '<td>R$ ' . number_format($row['valor'] ?? 0, 2, ',', '.') . '</td>';
                    echo '<td>' . htmlspecialchars($row['pagamento'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['nota_fiscal'] ?? '') . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-warning">Nenhum lançamento encontrado no período.</div>';
            }
        }
        ?>
    </div>
</li>
<li class="list-group-item">
    <b>Relatório por Categoria</b>
    <form class="row g-2 mt-2" method="get" action="#" id="formCategoria">
        <div class="col-md-8">
            <select class="form-select" name="categoria_filtro" id="categoria_filtro">
                <option value="">Selecione a categoria</option>
                <option value="Frete">Frete</option>
                <option value="Guincho">Guincho</option>
                <option value="Extra">Extra</option>
                <option value="Carro - Fox">Carro - Fox</option>
                <option value="Carro - F-350">Carro - F-350</option>
                <option value="Carro - Diversos">Carro - Diversos</option>
                <option value="Refeições">Refeições</option>
                <option value="Mercado">Mercado</option>
                <option value="Bancos">Bancos</option>
                <option value="Telefones">Telefones</option>
                <option value="Roupas">Roupas</option>
                <option value="Saúde">Saúde</option>
                <option value="Crianças">Crianças</option>
                <option value="Google">Google</option>
                <option value="Compras">Compras</option>
                <option value="Diversos">Diversos</option>
                <option value="Impostos">Impostos</option>
                <option value="Ajudantes">Ajudantes</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Gerar</button>
        </div>
    </form>
    <div id="relatorioCategoria" class="mt-3"<?php if(isset($_GET['categoria_filtro']) && $_GET['categoria_filtro']){echo '';}else{echo ' style="display:none;"';} ?>>
        <?php
        if (isset($_GET['categoria_filtro']) && $_GET['categoria_filtro']) {
            require_once '../db.php';
            $cat = $conn->real_escape_string($_GET['categoria_filtro']);
            $sql = "SELECT * FROM financeiro WHERE categoria = '$cat' ORDER BY data DESC, id DESC";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                echo '<div class="mb-2 d-flex gap-2">'
    .'<button class="btn btn-outline-success btn-sm" onclick="printTable(this)"><i class="fas fa-print"></i> Exibir</button>'
    .'<button class="btn btn-outline-danger btn-sm" onclick="exportTableToPDF(this)"><i class="fas fa-file-pdf"></i> Salvar PDF</button>'
    .'<button class="btn btn-outline-success btn-sm" onclick="exportTableToCSV(this)"><i class="fas fa-file-csv"></i> Salvar CSV</button>'
    .'<button class="btn btn-outline-secondary btn-sm" onclick="exportTableToTXT(this)"><i class="fas fa-file-alt"></i> Salvar TXT</button>'
.'</div>';
echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover align-middle shadow-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
                echo '</tr></thead><tbody>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    $tipoLabel = ($row['tipo'] === 'entrada') ? 'Receitas' : (($row['tipo'] === 'saida') ? 'Despesas' : ucfirst($row['tipo']));
echo '<td>' . htmlspecialchars($tipoLabel) . '</td>';
                    echo '<td>' . htmlspecialchars($row['categoria'] ?? '') . '</td>';
                    echo '<td>' . (!empty($row['data']) ? date('d/m/Y', strtotime($row['data'])) : '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['descricao'] ?? '') . '</td>';
                    echo '<td>R$ ' . number_format($row['valor'] ?? 0, 2, ',', '.') . '</td>';
                    echo '<td>' . htmlspecialchars($row['pagamento'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['nota_fiscal'] ?? '') . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-warning">Nenhum lançamento encontrado para a categoria selecionada.</div>';
            }
        }
        ?>
    </div>
</li>
<li class="list-group-item">
    <b>Relatório por Tipo</b>
    <form class="row g-2 mt-2" method="get" action="#" id="formTipo">
        <div class="col-md-8">
            <select class="form-select" name="tipo_filtro" id="tipo_filtro">
                <option value="">Selecione o tipo</option>
                <?php
                require_once '../db.php';
                $sqlTipos = "SELECT DISTINCT tipo FROM financeiro ORDER BY tipo";
                $resTipos = $conn->query($sqlTipos);
                if ($resTipos && $resTipos->num_rows > 0) {
                    while ($row = $resTipos->fetch_assoc()) {
                        $tipoVal = htmlspecialchars($row['tipo']);
$tipoLabel = $tipoVal === 'entrada' ? 'Receitas' : ($tipoVal === 'saida' ? 'Despesas' : ucfirst($tipoVal));
echo "<option value=\"$tipoVal\"";
if (isset($_GET['tipo_filtro']) && $_GET['tipo_filtro'] == $tipoVal) echo ' selected';
echo ">$tipoLabel</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Gerar</button>
        </div>
    </form>
    <div id="relatorioTipo" class="mt-3"<?php if(isset($_GET['tipo_filtro']) && $_GET['tipo_filtro']){echo '';}else{echo ' style=\"display:none;\"';} ?>>
        <?php
        if (isset($_GET['tipo_filtro']) && $_GET['tipo_filtro']) {
            $tipo = $conn->real_escape_string($_GET['tipo_filtro']);
            $sql = "SELECT * FROM financeiro WHERE tipo = '$tipo' ORDER BY data DESC, id DESC";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0) {
                echo '<div class="mb-2 d-flex gap-2">'
    .'<button class="btn btn-outline-success btn-sm" onclick="printTable(this)"><i class="fas fa-print"></i> Exibir</button>'
    .'<button class="btn btn-outline-danger btn-sm" onclick="exportTableToPDF(this)"><i class="fas fa-file-pdf"></i> Salvar PDF</button>'
    .'<button class="btn btn-outline-success btn-sm" onclick="exportTableToCSV(this)"><i class="fas fa-file-csv"></i> Salvar CSV</button>'
    .'<button class="btn btn-outline-secondary btn-sm" onclick="exportTableToTXT(this)"><i class="fas fa-file-alt"></i> Salvar TXT</button>'
.'</div>';
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover align-middle shadow-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
                echo '</tr></thead><tbody>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    $tipoLabel = ($row['tipo'] === 'entrada') ? 'Receitas' : (($row['tipo'] === 'saida') ? 'Despesas' : ucfirst($row['tipo']));
echo '<td>' . htmlspecialchars($tipoLabel) . '</td>';
                    echo '<td>' . htmlspecialchars($row['categoria'] ?? '') . '</td>';
                    echo '<td>' . (!empty($row['data']) ? date('d/m/Y', strtotime($row['data'])) : '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['descricao'] ?? '') . '</td>';
                    echo '<td>R$ ' . number_format($row['valor'] ?? 0, 2, ',', '.') . '</td>';
                    echo '<td>' . htmlspecialchars($row['pagamento'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['nota_fiscal'] ?? '') . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-warning">Nenhum lançamento encontrado para o tipo selecionado.</div>';
            }
        }
        ?>
    </div>
</li>
<li class="list-group-item">
    <b>Relatório Detalhado</b>
    <button type="button" class="btn btn-primary mt-2" id="btnDetalhado">Gerar Relatório</button>
    <div id="relatorioDetalhado" class="mt-3" style="display:none;">
        <?php
        require_once '../db.php';
        $sql = "SELECT * FROM financeiro ORDER BY data DESC, id DESC";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            echo '<div class="mb-2 d-flex gap-2">'
    .'<button class="btn btn-outline-success btn-sm" onclick="printTable(this)"><i class="fas fa-print"></i> Exibir</button>'
    .'<button class="btn btn-outline-danger btn-sm" onclick="exportTableToPDF(this)"><i class="fas fa-file-pdf"></i> Salvar PDF</button>'
    .'<button class="btn btn-outline-success btn-sm" onclick="exportTableToCSV(this)"><i class="fas fa-file-csv"></i> Salvar CSV</button>'
    .'<button class="btn btn-outline-secondary btn-sm" onclick="exportTableToTXT(this)"><i class="fas fa-file-alt"></i> Salvar TXT</button>'
.'</div>';
echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover align-middle shadow-sm">';
            echo '<thead class="table-dark"><tr>';
            echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
            echo '</tr></thead><tbody>';
            while ($row = $res->fetch_assoc()) {
                echo '<tr>';
                $tipoLabel = ($row['tipo'] === 'entrada') ? 'Receitas' : (($row['tipo'] === 'saida') ? 'Despesas' : ucfirst($row['tipo']));
echo '<td>' . htmlspecialchars($tipoLabel) . '</td>';
                echo '<td>' . htmlspecialchars($row['categoria'] ?? '') . '</td>';
                echo '<td>' . (!empty($row['data']) ? date('d/m/Y', strtotime($row['data'])) : '') . '</td>';
                echo '<td>' . htmlspecialchars($row['descricao'] ?? '') . '</td>';
                echo '<td>R$ ' . number_format($row['valor'] ?? 0, 2, ',', '.') . '</td>';
                echo '<td>' . htmlspecialchars($row['pagamento'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($row['nota_fiscal'] ?? '') . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-warning">Nenhum lançamento financeiro encontrado.</div>';
        }
        ?>
    </div>
</li>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Relatório detalhado
    document.getElementById('btnDetalhado').addEventListener('click', function() {
        var rel = document.getElementById('relatorioDetalhado');
        rel.style.display = rel.style.display === 'none' ? 'block' : 'none';
        this.textContent = rel.style.display === 'block' ? 'Ocultar Relatório' : 'Gerar Relatório';
    });
    // Relatório receitas vs despesas
    document.getElementById('btnReceitasDespesas').addEventListener('click', function() {
        var rel = document.getElementById('relatorioReceitasDespesas');
        rel.style.display = rel.style.display === 'none' ? 'block' : 'none';
        this.textContent = rel.style.display === 'block' ? 'Ocultar Relatório' : 'Gerar Relatório';
    });
    // Relatório por período
    document.getElementById('formPeriodo').addEventListener('submit', function(e) {
        e.preventDefault();
        var inicio = document.getElementById('periodo_inicio').value;
        var fim = document.getElementById('periodo_fim').value;
        if (inicio && fim) {
            window.location.href = '?periodo_inicio=' + inicio + '&periodo_fim=' + fim;
        }
    });
    // Relatório por categoria
    document.getElementById('formCategoria').addEventListener('submit', function(e) {
        e.preventDefault();
        var cat = document.getElementById('categoria_filtro').value;
        if (cat) {
            window.location.href = '?categoria_filtro=' + encodeURIComponent(cat);
        }
    });
});
</script>
                </ul>
                <div class="alert alert-secondary mb-0">Escolha um modo de relatório e clique em "Gerar" para visualizar os dados financeiros.</div>
            </div>
        </div>
    </div>
</div>
    </main>
<!-- jsPDF e autoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
<script>
function exportTableToPDF(btn) {
    // Procura a próxima .table-responsive após o botão
    var container = btn.parentNode.parentNode.querySelector('.table-responsive');
    if (!container) {
        alert('Tabela não encontrada!');
        return;
    }
    var table = container.querySelector('table');
    if (!table) {
        alert('Tabela não encontrada!');
        return;
    }
    var doc = new jspdf.jsPDF('l', 'pt', 'a4');
    doc.autoTable({
        html: table,
        theme: 'grid',
        headStyles: { fillColor: [33, 37, 41] },
        styles: { fontSize: 10 },
        margin: { top: 20 },
    });
    doc.save('relatorio.pdf');
}

function printTable(btn) {
    var table = btn.parentNode.nextElementSibling.querySelector('table');
    var doc = new jspdf.jsPDF('l', 'pt', 'a4');
    doc.autoTable({
        html: table,
        theme: 'grid',
        headStyles: { fillColor: [33, 37, 41] },
        styles: { fontSize: 10 },
        margin: { top: 20 },
    });
    window.open(doc.output('bloburl'), '_blank');
}

function exportTableToTXT(btn) {
    var table = btn.parentNode.nextElementSibling.querySelector('table');
    var rows = table.querySelectorAll('tr');
    let txt = '';
    for (let row of rows) {
        let cols = row.querySelectorAll('th, td');
        let rowData = [];
        for (let col of cols) {
            rowData.push(col.innerText.replace(/\n/g, ' '));
        }
        txt += rowData.join(';') + '\n';
    }
    let txtFile = new Blob([txt], {type: 'text/plain'});
    let link = document.createElement('a');
    link.download = 'relatorio.txt';
    link.href = window.URL.createObjectURL(txtFile);
    link.click();
}
function exportTableToCSV(btn) {
    var table = btn.parentNode.nextElementSibling.querySelector('table');
    var rows = table.querySelectorAll('tr');
    let csv = '';
    for (let row of rows) {
        let cols = row.querySelectorAll('th, td');
        let rowData = [];
        for (let col of cols) {
            // Aspas duplas para proteger campos com ;
            rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
        }
        csv += rowData.join(';') + '\n';
    }
    let csvFile = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
    let link = document.createElement('a');
    link.download = 'relatorio.csv';
    link.href = window.URL.createObjectURL(csvFile);
    link.click();
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</body>
</html>
