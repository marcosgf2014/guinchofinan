<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Veículos | Guincho</title>
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
            <a href="index.php" class="active"><i class="fas fa-car"></i> Veículos</a>
            <a href="../checklist/index.php"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-car"></i> Veículos</h1>
        <div class="row mb-4">
            <div class="col-md-8">
                <form class="d-flex" method="get" action="index.php">
                    <input class="form-control me-2" type="search" name="busca" placeholder="Buscar por cliente, placa ou modelo" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalCadastroVeiculo">
                    <i class="fas fa-plus"></i> Adicionar Veículo
                </button>
            </div>
        </div>
        <!-- Modal Cadastro Veículo -->
        <div class="modal fade" id="modalCadastroVeiculo" tabindex="-1" aria-labelledby="modalCadastroVeiculoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroVeiculoLabel"><i class="fas fa-car"></i> Novo Veículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form class="row g-3 p-3" method="post" action="salvar.php">
                        <div class="col-md-12">
                            <label for="cliente_id" class="form-label">Cliente Vinculado</label>
                            <select class="form-select" id="cliente_id" name="cliente_id" required>
                                <option value="">Selecione o cliente</option>
                                <?php
                                require_once '../db.php';
                                $res = $conn->query("SELECT id, nome FROM clientes ORDER BY nome ASC");
                                if ($res && $res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nome']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_veiculo" class="form-label">Tipo de Veículo</label>
                            <input type="text" class="form-control" id="tipo_veiculo" name="tipo_veiculo" placeholder="Ex: Caminhão, Carro, Moto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="placa" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="placa" name="placa" placeholder="Placa" required maxlength="10">
                        </div>
                        <div class="col-md-6">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo">
                        </div>
                        <div class="col-md-3">
                            <label for="ano" class="form-label">Ano</label>
                            <input type="number" class="form-control" id="ano" name="ano" placeholder="Ano" min="1900" max="2099">
                        </div>
                        <div class="col-md-3">
                            <label for="cor" class="form-label">Cor</label>
                            <input type="text" class="form-control" id="cor" name="cor" placeholder="Cor">
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Em andamento">Em andamento</option>
                                <option value="Concluído">Concluído</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="valor_servico" class="form-label">Valor do Serviço (R$)</label>
                            <input type="number" step="0.01" class="form-control" id="valor_servico" name="valor_servico" placeholder="Valor do Serviço" required>
                        </div>
                        <div class="col-md-6">
                            <label for="data_entrada" class="form-label">Data de Entrada</label>
                            <input type="date" class="form-control" id="data_entrada" name="data_entrada" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hora_entrada" class="form-label">Hora de Entrada (Brasília)</label>
                            <input type="time" class="form-control" id="hora_entrada" name="hora_entrada" required>
                        </div>
                        <div class="col-md-6">
                            <label for="data_saida" class="form-label">Data de Saída</label>
                            <input type="date" class="form-control" id="data_saida" name="data_saida">
                        </div>
                        <div class="col-md-6">
                            <label for="hora_saida" class="form-label">Hora de Saída</label>
                            <input type="time" class="form-control" id="hora_saida" name="hora_saida">
                        </div>
                        <div class="col-md-6">
                            <label for="origem" class="form-label">Origem</label>
                            <input type="text" class="form-control" id="origem" name="origem" placeholder="Origem">
                        </div>
                        <div class="col-md-6">
                            <label for="destino" class="form-label">Destino</label>
                            <input type="text" class="form-control" id="destino" name="destino" placeholder="Destino">
                        </div>
                        <div class="col-md-12">
                            <label for="obs" class="form-label">Obs.</label>
                            <textarea class="form-control" id="obs" name="obs" rows="2" placeholder="Observações"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="mt-4">
            <h2 class="mb-3"><i class="fas fa-list"></i> Lista de Veículos</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Valor</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../db.php';
                        // Filtro de busca
                        $where = '';
                        if (isset($_GET['busca']) && trim($_GET['busca']) !== '') {
                            $busca = $conn->real_escape_string($_GET['busca']);
                            $where = "WHERE c.nome LIKE '%$busca%' OR v.placa LIKE '%$busca%' OR v.modelo LIKE '%$busca%'";
                        }
                        $sql = "SELECT v.*, c.nome as cliente_nome FROM veiculos v LEFT JOIN clientes c ON v.cliente_id = c.id $where ORDER BY v.id ASC";
                        $res = $conn->query($sql);
                        if ($res && $res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['cliente_nome']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['placa']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
                                echo '<td>R$ ' . number_format($row['valor_servico'], 2, ',', '.') . '</td>';
                                echo '<td class="text-center">';
                                echo '<a href="#" class="btn-acao btn-checklist btn-checklist-veiculo me-1" title="Checklist"><i class="fas fa-clipboard-check"></i></a>';
echo '<a href="#" class="btn-acao btn-editar btn-editar-veiculo" title="Editar" 
    data-id="' . $row['id'] . '"
    data-cliente_id="' . $row['cliente_id'] . '"
    data-tipo_veiculo="' . htmlspecialchars($row['tipo_veiculo'], ENT_QUOTES) . '"
    data-placa="' . htmlspecialchars($row['placa'], ENT_QUOTES) . '"
    data-modelo="' . htmlspecialchars($row['modelo'], ENT_QUOTES) . '"
    data-ano="' . htmlspecialchars($row['ano'], ENT_QUOTES) . '"
    data-cor="' . htmlspecialchars($row['cor'], ENT_QUOTES) . '"
    data-status="' . htmlspecialchars($row['status'], ENT_QUOTES) . '"
    data-valor_servico="' . htmlspecialchars($row['valor_servico'], ENT_QUOTES) . '"
    data-data_entrada="' . htmlspecialchars($row['data_entrada'], ENT_QUOTES) . '"
    data-hora_entrada="' . htmlspecialchars($row['hora_entrada'], ENT_QUOTES) . '"
    data-data_saida="' . htmlspecialchars($row['data_saida'], ENT_QUOTES) . '"
    data-hora_saida="' . htmlspecialchars($row['hora_saida'], ENT_QUOTES) . '"
    data-origem="' . htmlspecialchars($row['origem'], ENT_QUOTES) . '"
    data-destino="' . htmlspecialchars($row['destino'], ENT_QUOTES) . '"
    data-obs="' . htmlspecialchars($row['obs'], ENT_QUOTES) . '">
    <i class="fas fa-edit"></i>
</a>';
                                echo '<a href="excluir.php?id=' . $row['id'] . '" class="btn-acao btn-excluir btn-excluir-veiculo" title="Excluir" onclick=\'return confirm("Tem certeza que deseja excluir este veículo?");\'><i class="fas fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="13" class="text-center">Nenhum veículo cadastrado ainda.</td></tr>';
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
    // Preencher modal para edição de veículo
    document.querySelectorAll('.btn-editar-veiculo').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('modalCadastroVeiculo'));
            document.getElementById('modalCadastroVeiculoLabel').innerHTML = '<i class="fas fa-car"></i> Editar Veículo';
            document.querySelector('#modalCadastroVeiculo form').action = 'salvar.php?id=' + btn.dataset.id;
            document.getElementById('cliente_id').value = btn.dataset.cliente_id;
            document.getElementById('tipo_veiculo').value = btn.dataset.tipo_veiculo;
            document.getElementById('placa').value = btn.dataset.placa;
            document.getElementById('modelo').value = btn.dataset.modelo;
            document.getElementById('ano').value = btn.dataset.ano;
            document.getElementById('cor').value = btn.dataset.cor;
            document.getElementById('status').value = btn.dataset.status;
            document.getElementById('valor_servico').value = btn.dataset.valor_servico;
            document.getElementById('data_entrada').value = btn.dataset.data_entrada;
            document.getElementById('hora_entrada').value = btn.dataset.hora_entrada;
            document.getElementById('data_saida').value = btn.dataset.data_saida;
            document.getElementById('hora_saida').value = btn.dataset.hora_saida;
            document.getElementById('origem').value = btn.dataset.origem;
            document.getElementById('destino').value = btn.dataset.destino;
            document.getElementById('obs').value = btn.dataset.obs;
            modal.show();
        });
    });
    // Ao fechar o modal, limpa o formulário e restaura para cadastro
    document.getElementById('modalCadastroVeiculo').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalCadastroVeiculoLabel').innerHTML = '<i class="fas fa-car"></i> Novo Veículo';
        document.querySelector('#modalCadastroVeiculo form').reset();
        document.querySelector('#modalCadastroVeiculo form').action = 'salvar.php';
    });
    // Fechar modal automaticamente após salvar/editar com sucesso
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') && urlParams.get('type') === 'success') {
            const modalEl = document.getElementById('modalCadastroVeiculo');
            if (modalEl && bootstrap && bootstrap.Modal.getInstance(modalEl)) {
                bootstrap.Modal.getInstance(modalEl).hide();
            }
        }
    });
    // Máscara para placa: XXX-XXXX
    document.getElementById('placa').addEventListener('input', function(e) {
        let v = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if (v.length > 3) v = v.slice(0,3) + '-' + v.slice(3);
        v = v.slice(0,8); // Limite máximo
        this.value = v;
    });
    </script>
</body>
</html>
