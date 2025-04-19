<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checklist | Guincho</title>
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
            <a href="index.php" class="active"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
            <a href="../relatorios/index.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
            
            
        </nav>
    </aside>
    <main class="main-content container py-4">
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'checklist_salvo'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                Checklist cadastrado com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <h1 class="mb-4"><i class="fas fa-clipboard-check"></i> Checklist</h1>
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <form class="d-flex" method="get" action="index.php">
                    <input class="form-control me-2" type="search" name="busca" placeholder="Buscar por veículo, placa, item, observação..." value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <a href="checklist_novo.php" class="btn btn-success px-4">
                    <i class="fas fa-plus"></i> Novo Checklist
                </a>
            </div>
        </div>
        <!-- Modal Cadastro Checklist -->
        <div class="modal fade" id="modalCadastroChecklist" tabindex="-1" aria-labelledby="modalCadastroChecklistLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroChecklistLabel"><i class="fas fa-clipboard-check"></i> Novo Checklist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form class="row g-3 p-3" method="post" action="salvar.php" enctype="multipart/form-data">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs mb-3" id="checklistTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="geral-tab" data-bs-toggle="tab" data-bs-target="#geral" type="button" role="tab">Geral</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detalhes-tab" data-bs-toggle="tab" data-bs-target="#detalhes" type="button" role="tab">Detalhes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="fotos-tab" data-bs-toggle="tab" data-bs-target="#fotos" type="button" role="tab">Fotos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="assinaturas-tab" data-bs-toggle="tab" data-bs-target="#assinaturas" type="button" role="tab">Assinaturas</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="checklistTabsContent">
                            <!-- Aba Geral -->
                            <div class="tab-pane fade show active" id="geral" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="quilometragem" class="form-label">Quilometragem</label>
                                        <input type="number" class="form-control" id="quilometragem" name="quilometragem" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="combustivel" class="form-label">Nível de Combustível</label>
                                        <select class="form-select" id="combustivel" name="combustivel" required>
                                            <option value="">Selecione</option>
                                            <option value="1/4">1/4</option>
                                            <option value="1/2">1/2</option>
                                            <option value="3/4">3/4</option>
                                            <option value="Cheio">Cheio</option>
                                            <option value="Reserva">Reserva</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="danos" name="danos">
                                    <label class="form-check-label" for="danos">Veículo possui danos externos visíveis</label>
                                </div>
                                <div class="mb-3">
                                    <label for="pertences" class="form-label">Pertences deixados no veículo</label>
                                    <textarea class="form-control" id="pertences" name="pertences" rows="2" placeholder="Liste os pertences deixados no veículo..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="observacoes" class="form-label">Observações Adicionais</label>
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="2" placeholder="Observações adicionais importantes..."></textarea>
                                </div>
                            </div>
                            <!-- Aba Detalhes -->
                            <div class="tab-pane fade" id="detalhes" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <h6>Rodas e Pneus</h6>
                                        <div class="mb-2">
                                            <label class="form-label">Pneus Dianteiros</label>
                                            <select class="form-select" name="pneus_dianteiros">
                                                <option value="">Selecione</option>
                                                <option>Bons</option>
                                                <option>Novo</option>
                                                <option>Ruim</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Pneus Traseiros</label>
                                            <select class="form-select" name="pneus_traseiros">
                                                <option value="">Selecione</option>
                                                <option>Bons</option>
                                                <option>Novo</option>
                                                <option>Ruim</option>
                                            </select>
                                        </div>s
                                        <div class="mb-2">
                                            <label class="form-label">Rodas Dianteiras</label>
                                            <select class="form-select" name="rodas_dianteiras">
                                                <option value="">Selecione</option>
                                                <option>Bom</option>
                                                <option>Novo</option>
                                                <option>Usado</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Rodas Traseiras</label>
                                            <select class="form-select" name="rodas_traseiras">
                                                <option value="">Selecione</option>
                                                <option>Bom</option>
                                                <option>Novo</option>
                                                <option>Usado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Acessórios</h6>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="calotas" name="calotas">
                                            <label class="form-check-label" for="calotas">Calotas</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="retrovisores" name="retrovisores">
                                            <label class="form-check-label" for="retrovisores">Retrovisores</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="palhetas" name="palhetas">
                                            <label class="form-check-label" for="palhetas">Palhetas</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="triangulo" name="triangulo">
                                            <label class="form-check-label" for="triangulo">Triângulo</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="macaco" name="macaco">
                                            <label class="form-check-label" for="macaco">Macaco / Chave Roda</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="estepe" name="estepe">
                                            <label class="form-check-label" for="estepe">Estepe</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Interior</h6>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="bancos" name="bancos">
                                            <label class="form-check-label" for="bancos">Bancos</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="painel" name="painel">
                                            <label class="form-check-label" for="painel">Painel</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="consoles" name="consoles">
                                            <label class="form-check-label" for="consoles">Consoles</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="forracao" name="forracao">
                                            <label class="form-check-label" for="forracao">Forração</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="tapetes" name="tapetes">
                                            <label class="form-check-label" for="tapetes">Tapetes</label>
                                        </div>
                                        <h6 class="mt-3">Outros</h6>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="bateria" name="bateria">
                                            <label class="form-check-label" for="bateria">Bateria</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="chaves" name="chaves">
                                            <label class="form-check-label" for="chaves">Chaves</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="documentos" name="documentos">
                                            <label class="form-check-label" for="documentos">Documentos</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="som" name="som">
                                            <label class="form-check-label" for="som">Som</label>
                                        </div>
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="caixa_selada" name="caixa_selada">
                                            <label class="form-check-label" for="caixa_selada">Caixa Selada</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Aba Fotos -->
                            <div class="tab-pane fade" id="fotos" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Adicionar Fotos do Veículo</label>
                                    <input class="form-control" type="file" name="fotos[]" id="fotos" multiple accept="image/*">
                                    <div id="previewFotos" class="row mt-3"></div>
                                </div>
                            </div>
                            <!-- Aba Assinaturas -->
                            <div class="tab-pane fade" id="assinaturas" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Assinatura do Cliente</label>
                                        <input type="file" class="form-control" name="assinatura_cliente" accept="image/*">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Assinatura do Responsável</label>
                                        <input type="file" class="form-control" name="assinatura_responsavel" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Salvar Checklist</button>
                        </div>
                        <div class="col-md-12">
                            <label for="itens" class="form-label">Itens (um por linha)</label>
                            <textarea class="form-control" id="itens" name="itens" rows="4" placeholder="Ex: Verificar óleo\nVerificar pneus\nVerificar documentos" required></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="mt-4">
            <h2 class="mb-3"><i class="fas fa-list"></i> Listagem de Checklists</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Data</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
require_once '../db.php';
$where = '';
if (isset($_GET['busca']) && $_GET['busca'] !== '') {
    $busca = $conn->real_escape_string($_GET['busca']);
    $where = "WHERE " .
        "cliente LIKE '%$busca%' OR " .
        "veiculo LIKE '%$busca%' OR " .
        "entrada LIKE '%$busca%' OR " .
        "origem LIKE '%$busca%' OR " .
        "destino LIKE '%$busca%' OR " .
        "quilometragem LIKE '%$busca%' OR " .
        "combustivel LIKE '%$busca%' OR " .
        "pneus_dianteiros LIKE '%$busca%' OR " .
        "pneus_traseiros LIKE '%$busca%' OR " .
        "rodas_dianteiras LIKE '%$busca%' OR " .
        "rodas_traseiras LIKE '%$busca%' OR " .
        "observacoes LIKE '%$busca%' OR " .
        "pertences LIKE '%$busca%'";
}
$sql = "SELECT id, cliente, veiculo, entrada FROM checklist ".$where." ORDER BY entrada DESC";
$res = $conn->query($sql);
if ($res && $res->num_rows > 0):
    while ($row = $res->fetch_assoc()):
        // Extrai placa do campo veiculo, se vier como "Modelo - Placa"
        $modelo = $row['veiculo'];
        $placa = '';
        if (strpos($modelo, ' - ') !== false) {
            [$modelo, $placa] = explode(' - ', $modelo, 2);
        }
?>
<tr>
    <td><?= htmlspecialchars($row['cliente']) ?></td>
    <td><?= htmlspecialchars($modelo) ?></td>
    <td><?= htmlspecialchars($placa) ?></td>
    <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($row['entrada']))) ?></td>
    <td class="text-center">
        <a href="checklist_novo.php?id=<?= $row['id'] ?>" class="btn-acao btn-editar me-2" title="Editar"><i class="fas fa-edit"></i></a>
        <a href="excluir.php?id=<?= $row['id'] ?>" class="btn-acao btn-excluir" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este checklist?');"><i class="fas fa-trash"></i></a>
    </td>
</tr>
<?php endwhile;
else:
?>
<tr><td colspan="5" class="text-center">Nenhum checklist cadastrado.</td></tr>
<?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Bootstrap JS Bundle (necessário para modal funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
