<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Checklist | Guincho</title>
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
            <a href="index.php" ><i class="fas fa-clipboard-check"></i> Checklist</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-clipboard-check"></i> Novo Checklist</h1>
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
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Dianteiras</label>
                                <select class="form-select" name="rodas_dianteiras">
                                    <option value="">Selecione</option>
                                    <option>Novo</option>
                                    <option>Usado</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Traseiras</label>
                                <select class="form-select" name="rodas_traseiras">
                                    <option value="">Selecione</option>
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
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
