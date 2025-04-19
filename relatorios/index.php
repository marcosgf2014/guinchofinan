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
            <a href="../index.php"><i class="fas fa-home"></i> Dashboard</a>
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
            <input type="date" class="form-control" name="inicio" id="periodo_inicio" placeholder="Data início">
        </div>
        <div class="col-md-5">
            <input type="date" class="form-control" name="fim" id="periodo_fim" placeholder="Data fim">
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
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover align-middle shadow-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
                echo '</tr></thead><tbody>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . ($row['tipo'] === 'entrada' ? 'Receita' : 'Despesas') . '</td>';
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
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped table-hover align-middle shadow-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
                echo '</tr></thead><tbody>';
                while ($row = $res->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . ($row['tipo'] === 'entrada' ? 'Receita' : 'Despesas') . '</td>';
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
    <b>Receitas vs Despesas</b>
    <button type="button" class="btn btn-primary mt-2" id="btnReceitasDespesas">Gerar Relatório</button>
    <div id="relatorioReceitasDespesas" class="mt-3" style="display:none;">
        <?php
        require_once '../db.php';
        $sql = "SELECT tipo, SUM(valor) as total FROM financeiro GROUP BY tipo";
        $res = $conn->query($sql);
        $entradas = 0; $saidas = 0;
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                if ($row['tipo'] === 'entrada') $entradas = $row['total'];
                if ($row['tipo'] === 'saida') $saidas = $row['total'];
            }
        }
        echo '<div class="row">';
        echo '<div class="col-md-6"><div class="alert alert-success">Total de Receitas: <b>R$ ' . number_format($entradas,2,',','.') . '</b></div></div>';
        echo '<div class="col-md-6"><div class="alert alert-danger">Total de Despesas: <b>R$ ' . number_format($saidas,2,',','.') . '</b></div></div>';
        echo '</div>';
        echo '<div class="alert alert-primary">Saldo: <b>R$ ' . number_format($entradas-$saidas,2,',','.') . '</b></div>';
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
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover align-middle shadow-sm">';
            echo '<thead class="table-dark"><tr>';
            echo '<th>Tipo</th><th>Categoria</th><th>Data</th><th>Descrição</th><th>Valor</th><th>Pagamento</th><th>Nota Fiscal</th>';
            echo '</tr></thead><tbody>';
            while ($row = $res->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . ($row['tipo'] === 'entrada' ? 'Receita' : 'Despesas') . '</td>';
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
</body>
</html>
