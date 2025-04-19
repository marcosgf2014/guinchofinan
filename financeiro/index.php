<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Financeiro | Guincho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
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
            <a href="index.php" class="active"><i class="fas fa-coins"></i> Financeiro</a>
            <a href="../relatorios/index.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
            
            
        </nav>
    </aside>
    <main class="main-content container py-4">
<?php
require_once '../db.php';
$resumo = ["entradas"=>0, "saidas"=>0, "saldo"=>0];
$sqlResumo = "SELECT tipo, SUM(valor) as total FROM financeiro GROUP BY tipo";
$resR = $conn->query($sqlResumo);
if ($resR) {
    while($r = $resR->fetch_assoc()) {
        if ($r['tipo'] == 'entrada') $resumo['entradas'] += $r['total'];
        if ($r['tipo'] == 'saida') $resumo['saidas'] += $r['total'];
    }
}
$resumo['saldo'] = $resumo['entradas'] - $resumo['saidas'];
?>
<div id="campos-resumo" class="row mb-4" style="display: none;">
    <div class="col-md-4">
        <div class="card text-bg-success mb-3"><div class="card-body"><h5 class="card-title mb-0 text-center" style="color:#111; font-weight:bold; font-size:2rem; letter-spacing:1px;">Entradas</h5><p class="card-text fs-4 mb-0">R$ <?= number_format($resumo['entradas'],2,',','.') ?></p></div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-danger mb-3"><div class="card-body"><h5 class="card-title mb-0 text-center" style="color:#111; font-weight:bold; font-size:2rem; letter-spacing:1px;">Saídas</h5><p class="card-text fs-4 mb-0">R$ <?= number_format($resumo['saidas'],2,',','.') ?></p></div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3"><div class="card-body"><h5 class="card-title mb-0 text-center" style="color:#111; font-weight:bold; font-size:2rem; letter-spacing:1px;">Saldo</h5><p class="card-text fs-4 mb-0">R$ <?= number_format($resumo['saldo'],2,',','.') ?></p></div></div>
    </div>
</div>

        <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="fas fa-coins"></i> Financeiro</h1>
    <button id="btn-visualizar" class="btn btn-outline-primary" type="button" onclick="mostrarCamposResumo()">Visualizar Resumo</button>
</div>
        
        <!-- Modal Cadastro Financeiro -->
        <div class="modal fade" id="modalCadastroFinanceiro" tabindex="-1" aria-labelledby="modalCadastroFinanceiroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroFinanceiroLabel"><i class="fas fa-coins"></i> <span id="tituloModal">Novo Lançamento</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form class="row g-3 p-3" method="post" action="salvar.php" enctype="multipart/form-data" id="formFinanceiro">
    <input type="hidden" id="id_lancamento" name="id_lancamento" value="">

                        <div class="col-md-6">
    <label for="tipo" class="form-label">Receitas/Despesas</label>
<select class="form-select" id="tipo" name="tipo">
    <option value="entrada">Receitas</option>
    <option value="saida">Despesas</option>
</select>
</div>
<div class="col-md-6">
    <label for="categoria" class="form-label">Categoria</label>
    <select class="form-select" id="categoria" name="categoria" required>
    <option value="">Selecione...</option>
    <option value="">Selecione...</option>
    <option value="Frete">Frete</option>
    <option value="Guincho">Guincho</option>
    <option value="Extra">Extra</option>
</select>
</div>
<div class="col-md-6">
    <label for="data" class="form-label">Data</label>
    <input type="date" class="form-control" id="data" name="data">
</div>

<div class="col-12">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição" rows="3"></textarea>
</div>
<div class="col-md-6">
    <label for="valor" class="form-label">Valor</label>
    <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor" required>
</div>
<div class="col-md-6">
    <label for="pagamento" class="form-label">Pagamento</label>
    <select class="form-select" id="pagamento" name="pagamento">
    <option value="">Selecione...</option>
    <option value="Pendente">Pendente</option>
    <option value="Dinheiro">Dinheiro</option>
    <option value="PJ - Banco do Brasil">PJ - Banco do Brasil</option>
    <option value="PJ - Mercado Pago">PJ - Mercado Pago</option>
    <option value="PJ - Outros">PJ - Outros</option>
    <option value="PF - Bradesco">PF - Bradesco</option>
    <option value="PF - Itaú">PF - Itaú</option>
    <option value="PF - Santander">PF - Santander</option>
    <option value="PF - Mercado Pago">PF - Mercado Pago</option>
    <option value="PF - Porto Seguro">PF - Porto Seguro</option>
    <option value="PF - Caixa">PF - Caixa</option>
    <option value="PF - Outros">PF - Outros</option>
</select>
</div>
<div class="col-md-6">
    <label for="nota_fiscal" class="form-label">Nota Fiscal</label>
    <input type="text" class="form-control" id="nota_fiscal" name="nota_fiscal" placeholder="Número ou info da Nota Fiscal">
</div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-4">
    <div class="row align-items-center">
        <div class="col-md-8 mb-2 mb-md-0">
            <form class="d-flex" method="get" action="index.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar por descrição, categoria, pagamento, nota fiscal, tipo..." value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search me-1"></i> Buscar</button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalCadastroFinanceiro">
                <i class="fas fa-plus me-1"></i> Novo Lançamento
            </button>
        </div>
    </div>
</div>
<section class="mt-4">
    <h2 class="mb-3"><i class="fas fa-list"></i> Lançamentos Financeiros</h2>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Receita</th>
<th>Categoria</th>
<th>Data</th>
<th>Descrição</th>
<th>Valor</th>
<th>Pagamento</th>
<th>Nota Fiscal</th>
<th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
require_once '../db.php';
$where = '';
if (!empty($_GET['busca'])) {
    $busca = $conn->real_escape_string($_GET['busca']);
    $where = "WHERE (
        descricao LIKE '%$busca%' OR 
        categoria LIKE '%$busca%' OR 
        pagamento LIKE '%$busca%' OR 
        nota_fiscal LIKE '%$busca%' OR 
        tipo LIKE '%$busca%' OR 
        data LIKE '%$busca%' OR
        valor LIKE '%$busca%'
    )";
}
$sql = "SELECT * FROM financeiro $where ORDER BY data DESC, id DESC";
$res = $conn->query($sql);
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . ($row['tipo'] === 'entrada' ? 'Receitas' : 'Despesas') . '</td>';
        echo '<td>' . htmlspecialchars($row['categoria'] ?? '') . '</td>';
        echo '<td>' . (!empty($row['data']) ? date('d-m-Y', strtotime($row['data'])) : '') . '</td>';
        echo '<td>' . htmlspecialchars($row['descricao'] ?? '') . '</td>';
        echo '<td>R$ ' . number_format($row['valor'] ?? 0, 2, ',', '.') . '</td>';
        echo '<td>' . htmlspecialchars($row['pagamento'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['nota_fiscal'] ?? '') . '</td>';
        echo '<td class="text-center">';
        echo '<a href="#" class="btn-acao btn-editar btn-editar-financeiro me-2" title="Editar" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></a>';
        echo '<a href="excluir.php?id=' . $row['id'] . '" class="btn-acao btn-excluir btn-excluir-financeiro" title="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este lançamento?\');"><i class="fas fa-trash"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8" class="text-center">Nenhum lançamento cadastrado ainda.</td></tr>';
}
?>
</tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Bootstrap JS Bundle (necessário para modal funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Categorias para cada tipo
const categoriasReceita = [
    {value: '', label: 'Selecione...'},
    {value: 'Frete', label: 'Frete'},
    {value: 'Guincho', label: 'Guincho'},
    {value: 'Extra', label: 'Extra'}
];
const categoriasSaida = [
    {value: '', label: 'Selecione...'},
    {value: 'Carro - Fox', label: 'Carro - Fox'},
    {value: 'Carro - F-350', label: 'Carro - F-350'},
    {value: 'Carro - Diversos', label: 'Carro - Diversos'},
    {value: 'Refeições', label: 'Refeições'},
    {value: 'Mercado', label: 'Mercado'},
    {value: 'Bancos', label: 'Bancos'},
    {value: 'Telefones', label: 'Telefones'},
    {value: 'Roupas', label: 'Roupas'},
    {value: 'Saúde', label: 'Saúde'},
    {value: 'Crianças', label: 'Crianças'},
    {value: 'Google', label: 'Google'},
    {value: 'Compras', label: 'Compras'},
    {value: 'Diversos', label: 'Diversos'},
    {value: 'Impostos', label: 'Impostos'},
    {value: 'Ajudantes', label: 'Ajudantes'}
];
function atualizarCategorias() {
    const tipo = document.getElementById('tipo').value;
    const cat = document.getElementById('categoria');
    let opcoes = tipo === 'entrada' ? categoriasReceita : categoriasSaida;
    let valorAtual = cat.value;
    cat.innerHTML = '';
    opcoes.forEach(function(opt) {
        let o = document.createElement('option');
        o.value = opt.value;
        o.textContent = opt.label;
        cat.appendChild(o);
    });
    // Se valor atual existir na nova lista, mantém selecionado
    if ([...cat.options].some(o=>o.value===valorAtual)) cat.value = valorAtual;
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tipo').addEventListener('change', atualizarCategorias);
    atualizarCategorias();

    // Edição: ao clicar em Editar
    document.querySelectorAll('.btn-editar-financeiro').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            fetch('get_lancamento.php?id=' + id)
                .then(resp => resp.json())
                .then(data => {
                    if(data.erro) {
                        alert(data.erro);
                        return;
                    }
                    document.getElementById('id_lancamento').value = data.id;
                    document.getElementById('tipo').value = data.tipo;
                    atualizarCategorias();
                    document.getElementById('categoria').value = data.categoria;
                    document.getElementById('data').value = data.data;
                    document.getElementById('descricao').value = data.descricao;
                    document.getElementById('valor').value = data.valor;
                    document.getElementById('pagamento').value = data.pagamento;
                    document.getElementById('nota_fiscal').value = data.nota_fiscal;
                    document.getElementById('tituloModal').textContent = 'Editar Lançamento';
                    var modal = new bootstrap.Modal(document.getElementById('modalCadastroFinanceiro'));
                    modal.show();
                });
        });
    });

    // Ao fechar modal, limpa o formulário
    document.getElementById('modalCadastroFinanceiro').addEventListener('hidden.bs.modal', function () {
        document.getElementById('id_lancamento').value = '';
        document.getElementById('tipo').value = 'entrada';
        atualizarCategorias();
        document.getElementById('categoria').value = '';
        document.getElementById('data').value = '';
        document.getElementById('descricao').value = '';
        document.getElementById('valor').value = '';
        document.getElementById('pagamento').value = '';
        document.getElementById('nota_fiscal').value = '';
        document.getElementById('tituloModal').textContent = 'Novo Lançamento';
    });
});
// Validação dos campos obrigatórios no modal financeiro
    document.getElementById('formFinanceiro').addEventListener('submit', function(e) {
        let categoria = document.getElementById('categoria');
        let valor = document.getElementById('valor');
        let valido = true;
        // Remove classes anteriores
        categoria.classList.remove('is-invalid');
        valor.classList.remove('is-invalid');
        // Categoria
        if (!categoria.value) {
            categoria.classList.add('is-invalid');
            valido = false;
        }
        // Valor
        if (!valor.value || parseFloat(valor.value) <= 0) {
            valor.classList.add('is-invalid');
            valido = false;
        }
        if (!valido) {
            e.preventDefault();
        }
    });
</script>
<script>
function mostrarCamposResumo() {
    var campos = document.getElementById('campos-resumo');
    var btn = document.getElementById('btn-visualizar');
    if (campos.style.display === "none") {
        campos.style.display = "flex";
        btn.textContent = "Ocultar Resumo";
    } else {
        campos.style.display = "none";
        btn.textContent = "Visualizar Resumo";
    }
}
</script>
<style>
.is-invalid { border-color: #dc3545 !important; }
.is-invalid:focus { box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25) !important; }
</style>
</body>
</html>
