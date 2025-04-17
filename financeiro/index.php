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
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-coins"></i> Financeiro</h1>
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- Espaço para busca futura, se desejar -->
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalCadastroFinanceiro">
                    <i class="fas fa-plus"></i> Novo Lançamento
                </button>
            </div>
        </div>
        <!-- Modal Cadastro Financeiro -->
        <div class="modal fade" id="modalCadastroFinanceiro" tabindex="-1" aria-labelledby="modalCadastroFinanceiroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroFinanceiroLabel"><i class="fas fa-coins"></i> Novo Lançamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form class="row g-3 p-3" method="post" action="salvar.php">
                        <div class="col-md-6">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Cliente">
                        </div>
                        <div class="col-md-6">
                            <label for="veiculo" class="form-label">Veículo</label>
                            <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Veículo">
                        </div>
                        <div class="col-md-6">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" name="data">
                        </div>
                        <div class="col-md-6">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="number" step="0.01" class="form-control" id="valor" name="valor" placeholder="Valor">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo">
                                <option value="entrada">Entrada</option>
                                <option value="saida">Saída</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="mt-4">
            <h2 class="mb-3"><i class="fas fa-list"></i> Lançamentos Financeiros</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Veículo</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th class="text-center">Ações</th>
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
                                echo '<td class="text-center">';
                                echo '<a href="#" class="btn-acao btn-editar btn-editar-financeiro me-2" title="Editar"><i class="fas fa-edit"></i></a>';
                                echo '<a href="#" class="btn-acao btn-excluir btn-excluir-financeiro" title="Excluir"><i class="fas fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">Nenhum lançamento cadastrado ainda.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Bootstrap JS Bundle (necessário para modal funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
