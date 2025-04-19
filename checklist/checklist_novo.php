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
<?php
require_once '../db.php';
$edit = false;
$checklist = [];
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM checklist WHERE id = $id LIMIT 1");
    if ($res && $res->num_rows) {
        $checklist = $res->fetch_assoc();
        $edit = true;
    }
}
?>
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
        <h1 class="mb-4"><i class="fas fa-clipboard-check"></i> <?= $edit ? 'Editar Checklist' : 'Novo Checklist' ?></h1>
        <form class="row g-3 p-3" method="post" action="salvar.php" enctype="multipart/form-data">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($checklist['id']) ?>">
    <?php endif; ?>
            <div class="row mb-3 align-items-end">
                <!-- Primeira linha: Cliente, Veículo, Data -->
                <div class="col-md-5">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Nome do cliente" value="<?= $edit ? htmlspecialchars($checklist['cliente']) : (isset($_GET['cliente']) ? htmlspecialchars($_GET['cliente']) : '') ?>" required <?= $edit ? 'readonly' : '' ?> >
                </div>
                <div class="col-md-5">
                    <label for="veiculo" class="form-label">Veículo</label>
                    <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Veículo" value="<?= $edit ? htmlspecialchars($checklist['veiculo']) : (isset($_GET['veiculo']) ? htmlspecialchars($_GET['veiculo']) : '') ?>" required <?= $edit ? 'readonly' : '' ?>>
                </div>
                <div class="col-md-2">
                    <label for="entrada" class="form-label">Entrada</label>
                    <?php date_default_timezone_set('America/Sao_Paulo'); ?>
                    <input type="datetime-local" class="form-control" id="entrada" name="entrada" value="<?= date('Y-m-d\TH:i') ?>" required <?= $edit ? 'readonly' : '' ?>>
                </div>
            </div>
            <!-- Segunda linha: Origem, Destino -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem" placeholder="Local de origem" value="<?= $edit ? htmlspecialchars($checklist['origem']) : '' ?>">
                </div>
                <div class="col-md-6">
                    <label for="destino" class="form-label">Destino</label>
                    <input type="text" class="form-control" id="destino" name="destino" placeholder="Local de destino" value="<?= $edit ? htmlspecialchars($checklist['destino']) : '' ?>">
                </div>
            </div>
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
                            <input type="number" class="form-control" id="quilometragem" name="quilometragem" value="<?= $edit ? htmlspecialchars($checklist['quilometragem']) : '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="combustivel" class="form-label">Nível de Combustível</label>
                            <select class="form-select" id="combustivel" name="combustivel">
    <?php $combustivel_sel = $edit ? $checklist['combustivel'] : ''; ?>
                                <option value="">Selecione</option>
                                <option value="1/4" <?= ($combustivel_sel == '1/4') ? 'selected' : '' ?>>1/4</option>
<option value="1/2" <?= ($combustivel_sel == '1/2') ? 'selected' : '' ?>>1/2</option>
<option value="3/4" <?= ($combustivel_sel == '3/4') ? 'selected' : '' ?>>3/4</option>
<option value="Cheio" <?= ($combustivel_sel == 'Cheio') ? 'selected' : '' ?>>Cheio</option>
<option value="Reserva" <?= ($combustivel_sel == 'Reserva') ? 'selected' : '' ?>>Reserva</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="danos" name="danos" <?= ($edit && $checklist['danos']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="danos">Veículo possui danos externos visíveis</label>
                    </div>
                    <div class="mb-3">
                        <label for="pertences" class="form-label">Pertences deixados no veículo</label>
                        <textarea class="form-control" id="pertences" name="pertences" rows="2" placeholder="Liste os pertences deixados no veículo..."><?= $edit ? htmlspecialchars($checklist['pertences']) : '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações Adicionais</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="2" placeholder="Observações adicionais importantes..."><?= $edit ? htmlspecialchars($checklist['observacoes']) : '' ?></textarea>
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
    <?php $pneus_dianteiros_sel = $edit ? $checklist['pneus_dianteiros'] : ''; ?>
                                    <option value="">Selecione</option>
                                    <option value="Bom" <?= ($pneus_dianteiros_sel == 'Bom') ? 'selected' : '' ?>>Bom</option>
                                    <option value="Novo" <?= ($pneus_dianteiros_sel == 'Novo') ? 'selected' : '' ?>>Novo</option>
                                    <option value="Ruim" <?= ($pneus_dianteiros_sel == 'Ruim') ? 'selected' : '' ?>>Ruim</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Pneus Traseiros</label>
                                <select class="form-select" name="pneus_traseiros">
    <?php $pneus_traseiros_sel = $edit ? $checklist['pneus_traseiros'] : ''; ?>
                                    <option value="">Selecione</option>
                                    <option value="Bom" <?= ($pneus_traseiros_sel == 'Bom') ? 'selected' : '' ?>>Bom</option>
                                    <option value="Novo" <?= ($pneus_traseiros_sel == 'Novo') ? 'selected' : '' ?>>Novo</option>
                                    <option value="Ruim" <?= ($pneus_traseiros_sel == 'Ruim') ? 'selected' : '' ?>>Ruim</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Dianteiras</label>
                                <select class="form-select" name="rodas_dianteiras">
    <?php $rodas_dianteiras_sel = $edit ? $checklist['rodas_dianteiras'] : ''; ?>
                                    <option value="">Selecione</option>
                                    <option value="Bom" <?= ($rodas_dianteiras_sel == 'Bom') ? 'selected' : '' ?>>Bom</option>
                                    <option value="Novo" <?= ($rodas_dianteiras_sel == 'Novo') ? 'selected' : '' ?>>Novo</option>
                                    <option value="Ruim" <?= ($rodas_dianteiras_sel == 'Ruim') ? 'selected' : '' ?>>Ruim</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Rodas Traseiras</label>
                                <select class="form-select" name="rodas_traseiras">
    <?php $rodas_traseiras_sel = $edit ? $checklist['rodas_traseiras'] : ''; ?>
                                    <option value="">Selecione</option>
                                    <option value="Bom" <?= ($rodas_traseiras_sel == 'Bom') ? 'selected' : '' ?>>Bom</option>
                                    <option value="Novo" <?= ($rodas_traseiras_sel == 'Novo') ? 'selected' : '' ?>>Novo</option>
                                    <option value="Ruim" <?= ($rodas_traseiras_sel == 'Ruim') ? 'selected' : '' ?>>Ruim</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>Acessórios</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="calotas" name="calotas" <?= ($edit && $checklist['calotas']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="calotas">Calotas</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="retrovisores" name="retrovisores" <?= ($edit && $checklist['retrovisores']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="retrovisores">Retrovisores</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="palhetas" name="palhetas" <?= ($edit && $checklist['palhetas']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="palhetas">Palhetas</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="triangulo" name="triangulo" <?= ($edit && $checklist['triangulo']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="triangulo">Triângulo</label>
                            </div>
                            <div class="form-check form-switch mb-1">
    <input class="form-check-input" type="checkbox" id="macaco" name="macaco" <?= ($edit && $checklist['macaco']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="macaco">Macaco</label>
</div>
<div class="form-check form-switch mb-1">
    <input class="form-check-input" type="checkbox" id="chave_roda" name="chave_roda" <?= ($edit && isset($checklist['chave_roda']) && $checklist['chave_roda']) ? 'checked' : '' ?> >
    <label class="form-check-label" for="chave_roda">Chave do Roda</label>
</div>
<div class="form-check form-switch mb-1">
    <input class="form-check-input" type="checkbox" id="estepe" name="estepe" <?= ($edit && $checklist['estepe']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="estepe">Estepe</label>
</div>
                        </div>
                        <div class="col-md-4">
                            <h6>Interior</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="bancos" name="bancos" <?= ($edit && $checklist['bancos']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="bancos">Bancos</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="painel" name="painel" <?= ($edit && $checklist['painel']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="painel">Painel</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="consoles" name="consoles" <?= ($edit && $checklist['consoles']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="consoles">Consoles</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="forracao" name="forracao" <?= ($edit && $checklist['forracao']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="forracao">Forração</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="tapetes" name="tapetes" <?= ($edit && $checklist['tapetes']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="tapetes">Tapetes</label>
                            </div>
                            <h6 class="mt-3">Outros</h6>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="bateria" name="bateria" <?= ($edit && $checklist['bateria']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="bateria">Bateria</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="chaves" name="chaves" <?= ($edit && $checklist['chaves']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="chaves">Chaves</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="documentos" name="documentos" <?= ($edit && $checklist['documentos']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="documentos">Documentos</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="som" name="som" <?= ($edit && $checklist['som']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="som">Som</label>
                            </div>
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="caixa_selada" name="caixa_selada" <?= ($edit && $checklist['caixa_selada']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="caixa_selada">Caixa Selada</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Aba Fotos -->
                <div class="tab-pane fade" id="fotos" role="tabpanel">
    <div class="mb-3">
        <label class="form-label">Fotos do Veículo</label>
        <div id="uploadArea" style="border:2px dashed #b5b5b5; border-radius:12px; padding:2px; min-height:24px; text-align:center; background:#fafbfc; margin-bottom:20px;">
            <div style="font-size:2rem; color:#bbb;"><i class="fas fa-camera"></i></div>
            <div style="font-weight:bold; font-size:1.1rem; margin-top:8px;">Adicionar Fotos do Veículo</div>
            <div style="color:#888; font-size:0.95rem; margin-bottom:16px;">Faça upload de imagens para documentar a condição do veículo</div>
            <input type="file" id="inputFotos" name="fotos[]" accept="image/*" multiple style="display:none;">
            <button type="button" class="btn btn-primary" id="btnEscolherFotos" style="width:170px; height:50px;"><i class="fas fa-upload"></i> Escolher Imagens</button>
            <div id="uploadFeedback" class="mt-2"></div>
        </div>
        <div id="galeriaFotos" class="row g-3"></div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEscolher = document.getElementById('btnEscolherFotos');
        const inputFotos = document.getElementById('inputFotos');
        const feedback = document.getElementById('uploadFeedback');
        const galeria = document.getElementById('galeriaFotos');
        const uploadArea = document.getElementById('uploadArea');
        let checklistId = document.querySelector('input[name="id"]') ? document.querySelector('input[name="id"]').value : null;

        // Clique no botão abre o input
        btnEscolher.addEventListener('click', () => inputFotos.click());

        // Drag and Drop
        uploadArea.addEventListener('dragover', e => {
            e.preventDefault();
            uploadArea.style.background = '#f0f4fa';
        });
        uploadArea.addEventListener('dragleave', e => {
            uploadArea.style.background = '#fafbfc';
        });
        uploadArea.addEventListener('drop', e => {
            e.preventDefault();
            uploadArea.style.background = '#fafbfc';
            inputFotos.files = e.dataTransfer.files;
            enviarFotos(e.dataTransfer.files);
        });

        // Seleção via input
        inputFotos.addEventListener('change', function () {
            if (inputFotos.files.length) {
                enviarFotos(inputFotos.files);
            }
        });

        // Função para enviar fotos via AJAX
        function enviarFotos(files) {
            if (!checklistId) {
                feedback.innerHTML = '<span class="text-danger">Salve o checklist antes de enviar fotos.</span>';
                return;
            }
            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('fotos[]', files[i]);
            }
            formData.append('checklist_id', checklistId);
            feedback.innerHTML = 'Enviando...';
            btnEscolher.disabled = true;
            fetch('upload_foto.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    feedback.innerHTML = '<span class="text-success">Fotos enviadas!</span>';
                    inputFotos.value = '';
                    carregarGaleria();
                } else {
                    feedback.innerHTML = '<span class="text-danger">' + (data.message || 'Erro ao enviar fotos.') + '</span>';
                }
            })
            .catch(() => {
                feedback.innerHTML = '<span class="text-danger">Erro ao enviar fotos.</span>';
            })
            .finally(() => {
                btnEscolher.disabled = false;
            });
        }

        // Carregar galeria de fotos já salvas
        function carregarGaleria() {
            if (!checklistId) return;
            galeria.innerHTML = '<div class="text-center text-muted">Carregando fotos...</div>';
            fetch('listar_fotos.php?checklist_id=' + checklistId)
                .then(res => res.json())
                .then(data => {
                    galeria.innerHTML = '';
                    if (data.fotos && data.fotos.length) {
                        data.fotos.forEach((foto, idx) => {
                            galeria.innerHTML += `
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm position-relative">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-excluir-foto" data-id="${foto.id}" title="Excluir" style="z-index:2;">&times;</button>
                                        <img src="../uploads/${foto.caminho}" class="card-img-top" style="object-fit:cover; max-height:160px;">
                                        <div class="card-body p-2 text-center"><small>Foto ${idx+1}</small></div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        galeria.innerHTML = '<div class="text-center text-muted">Nenhuma foto enviada ainda.</div>';
                    }
                    // Eventos de exclusão
                    setTimeout(() => {
                        galeria.querySelectorAll('.btn-excluir-foto').forEach(btn => {
                            btn.onclick = function() {
                                if (!confirm('Tem certeza que deseja excluir esta foto?')) return;
                                let id = this.getAttribute('data-id');
                                fetch('excluir_foto.php', {
                                    method: 'POST',
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                    body: 'id=' + encodeURIComponent(id)
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        carregarGaleria();
                                    } else {
                                        alert(data.message || 'Erro ao excluir foto.');
                                    }
                                });
                            };
                        });
                    }, 100);
                });
        }
        if (checklistId) carregarGaleria();
    });
    </script>

                        </script>
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
    <script src="checklist_novo.js"></script>
</body>
</html>
