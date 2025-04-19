<?php
include __DIR__ . '/../db.php';
// Busca checklist pelo id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM checklist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $checklist = $result->fetch_assoc();
    $stmt->close();
} else {
    header('Location: index.php?msg=Checklist não encontrado!');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Checklist</title>
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
            <a href="index.php" class="active"><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-edit"></i> Editar Checklist</h1>
        <form class="row g-3 p-3" method="post" action="salvar_checklist.php?id=<?= $checklist['id'] ?>" enctype="multipart/form-data">
            <div class="row mb-3 align-items-end">
                <div class="col-md-5">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" value="<?= htmlspecialchars($checklist['cliente']) ?>">
                </div>
                <div class="col-md-5">
                    <label for="veiculo" class="form-label">Veículo</label>
                    <input type="text" class="form-control" id="veiculo" name="veiculo" value="<?= htmlspecialchars($checklist['veiculo']) ?>">
                </div>
                <div class="col-md-2">
                    <label for="entrada" class="form-label">Entrada</label>
                    <?php date_default_timezone_set('America/Sao_Paulo'); $dataAtual = date('Y-m-d\TH:i'); ?>
                    <input type="datetime-local" class="form-control" id="entrada" value="<?= $dataAtual ?>" readonly disabled>
                    <input type="hidden" name="entrada" value="<?= $dataAtual ?>">
                </div>
            </div>
            <div class="row mb-3 align-items-end">
                <div class="col-md-6">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem" placeholder="Local de origem" value="<?php echo isset($_GET['origem']) ? htmlspecialchars($_GET['origem']) : htmlspecialchars($checklist['origem'] ?? ''); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="destino" class="form-label">Destino</label>
                    <input type="text" class="form-control" id="destino" name="destino" placeholder="Local de destino" value="<?php echo isset($_GET['destino']) ? htmlspecialchars($_GET['destino']) : htmlspecialchars($checklist['destino'] ?? ''); ?>" readonly>
                </div>
                </div>
            </div>
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
                            <input type="number" class="form-control" id="quilometragem" name="quilometragem" value="<?= htmlspecialchars($checklist['quilometragem']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="combustivel" class="form-label">Nível de Combustível</label>
                            <select class="form-select" id="combustivel" name="combustivel">
                                <option value="">Selecione</option>
                                <option value="1/4" <?= $checklist['nivel_combustivel']=='1/4'?'selected':'' ?>>1/4</option>
                                <option value="1/2" <?= $checklist['nivel_combustivel']=='1/2'?'selected':'' ?>>1/2</option>
                                <option value="3/4" <?= $checklist['nivel_combustivel']=='3/4'?'selected':'' ?>>3/4</option>
                                <option value="Cheio" <?= $checklist['nivel_combustivel']=='Cheio'?'selected':'' ?>>Cheio</option>
                                <option value="Reserva" <?= $checklist['nivel_combustivel']=='Reserva'?'selected':'' ?>>Reserva</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="danos" name="danos_externos" <?= $checklist['danos_externos']?'checked':'' ?>>
                        <label class="form-check-label" for="danos">Veículo possui danos externos visíveis</label>
                    </div>
                    <div class="mb-3">
                        <label for="pertences" class="form-label">Pertences deixados no veículo</label>
                        <textarea class="form-control" id="pertences" name="pertences" rows="2"><?= htmlspecialchars($checklist['pertences']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações Adicionais</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="2"><?= htmlspecialchars($checklist['observacoes']) ?></textarea>
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
                                    <option <?= $checklist['pneus_dianteiros']=='Bons'?'selected':'' ?>>Bons</option>
                                    <option <?= $checklist['pneus_dianteiros']=='Novo'?'selected':'' ?>>Novo</option>
                                    <option <?= $checklist['pneus_dianteiros']=='Ruim'?'selected':'' ?>>Ruim</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Pneus Traseiros</label>
                                <select class="form-select" name="pneus_traseiros">
                                    <option value="">Selecione</option>
                                    <option <?= $checklist['pneus_traseiros']=='Bons'?'selected':'' ?>>Bons</option>
                                    <option <?= $checklist['pneus_traseiros']=='Novo'?'selected':'' ?>>Novo</option>
                                    <option <?= $checklist['pneus_traseiros']=='Ruim'?'selected':'' ?>>Ruim</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Dianteiras</label>
                                <select class="form-select" name="rodas_dianteiras">
                                    <option value="">Selecione</option>
                                    <option <?= $checklist['rodas_dianteiras']=='Novo'?'selected':'' ?>>Novo</option>
                                    <option <?= $checklist['rodas_dianteiras']=='Usado'?'selected':'' ?>>Usado</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Traseiras</label>
                                <select class="form-select" name="rodas_traseiras">
                                    <option value="">Selecione</option>
                                    <option <?= $checklist['rodas_traseiras']=='Novo'?'selected':'' ?>>Novo</option>
                                    <option <?= $checklist['rodas_traseiras']=='Usado'?'selected':'' ?>>Usado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Acessórios</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="calotas" name="calotas" <?= $checklist['calotas']?'checked':'' ?>>
                                <label class="form-check-label" for="calotas">Calotas</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="retrovisores" name="retrovisores" <?= $checklist['retrovisores']?'checked':'' ?>>
                                <label class="form-check-label" for="retrovisores">Retrovisores</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="palhetas" name="palhetas" <?= $checklist['palhetas']?'checked':'' ?>>
                                <label class="form-check-label" for="palhetas">Palhetas</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="triangulo" name="triangulo" <?= $checklist['triangulo']?'checked':'' ?>>
                                <label class="form-check-label" for="triangulo">Triângulo</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="macaco" name="macaco_chave" <?= $checklist['macaco_chave']?'checked':'' ?>>
                                <label class="form-check-label" for="macaco">Macaco / Chave Roda</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="estepe" name="estepe" <?= $checklist['estepe']?'checked':'' ?>>
                                <label class="form-check-label" for="estepe">Estepe</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Interior</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="bancos" name="bancos" <?= $checklist['bancos']?'checked':'' ?>>
                                <label class="form-check-label" for="bancos">Bancos</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="painel" name="painel" <?= $checklist['painel']?'checked':'' ?>>
                                <label class="form-check-label" for="painel">Painel</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="consoles" name="consoles" <?= $checklist['consoles']?'checked':'' ?>>
                                <label class="form-check-label" for="consoles">Consoles</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="forracao" name="forracao" <?= $checklist['forracao']?'checked':'' ?>>
                                <label class="form-check-label" for="forracao">Forração</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="tapetes" name="tapetes" <?= $checklist['tapetes']?'checked':'' ?>>
                                <label class="form-check-label" for="tapetes">Tapetes</label>
                            </div>
                            <h6 class="mt-3">Outros</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="bateria" name="bateria" <?= $checklist['bateria']?'checked':'' ?>>
                                <label class="form-check-label" for="bateria">Bateria</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="chaves" name="chaves" <?= $checklist['chaves']?'checked':'' ?>>
                                <label class="form-check-label" for="chaves">Chaves</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="documentos" name="documentos" <?= $checklist['documentos']?'checked':'' ?>>
                                <label class="form-check-label" for="documentos">Documentos</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="som" name="som" <?= $checklist['som']?'checked':'' ?>>
                                <label class="form-check-label" for="som">Som</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="caixa_selada" name="caixa_selada" <?= $checklist['caixa_selada']?'checked':'' ?>>
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
                        <?php if (!empty($checklist['fotos'])): ?>
                            <div class="mt-2">Arquivos enviados: <?= htmlspecialchars($checklist['fotos']) ?></div>
                        <?php endif; ?>
                        <div id="previewFotos" class="row mt-3"></div>
                    </div>
                </div>
                <!-- Aba Assinaturas -->
                <div class="tab-pane fade" id="assinaturas" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assinatura do Cliente</label>
                            <input type="file" class="form-control" name="assinatura_cliente" accept="image/*">
                            <?php if (!empty($checklist['assinatura_cliente'])): ?>
                                <div class="mt-2">Arquivo enviado: <?= htmlspecialchars($checklist['assinatura_cliente']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assinatura do Responsável</label>
                            <input type="file" class="form-control" name="assinatura_responsavel" accept="image/*">
                            <?php if (!empty($checklist['assinatura_responsavel'])): ?>
                                <div class="mt-2">Arquivo enviado: <?= htmlspecialchars($checklist['assinatura_responsavel']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Alterações</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
