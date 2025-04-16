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
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-car"></i> Veículos</h1>
        <div class="row mb-4">
            <div class="col-md-12 text-end">
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
                            <th>Tipo</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Cor</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>Obs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../db.php';
                        $sql = "SELECT v.*, c.nome as cliente_nome FROM veiculos v LEFT JOIN clientes c ON v.cliente_id = c.id ORDER BY v.id DESC";
                        $res = $conn->query($sql);
                        if ($res && $res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['cliente_nome']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['tipo_veiculo']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['placa']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['ano']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['cor']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td>R$ ' . number_format($row['valor_servico'], 2, ',', '.') . '</td>';
                                echo '<td>' . htmlspecialchars($row['data_entrada']) . ' ' . htmlspecialchars($row['hora_entrada']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['data_saida']) . ' ' . htmlspecialchars($row['hora_saida']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['origem']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['destino']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['obs']) . '</td>';
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
</body>
</html>
