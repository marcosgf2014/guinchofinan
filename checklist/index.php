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
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-clipboard-check"></i> Checklist</h1>
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- Espaço para busca futura, se desejar -->
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalCadastroChecklist">
                    <i class="fas fa-plus"></i> Novo Checklist
                </button>
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
                    <form class="row g-3 p-3" method="post" action="salvar.php">
                        <div class="col-md-12">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título do checklist" required>
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
                            <th>Título</th>
                            <th>Itens</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemplo de linha; substitua por PHP para listar do banco -->
                        <tr>
                            <td>Checklist de Caminhão</td>
                            <td>
                                <ul class="mb-0">
                                    <li>Verificar óleo</li>
                                    <li>Verificar pneus</li>
                                    <li>Verificar documentos</li>
                                </ul>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-acao btn-editar me-2" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn-acao btn-excluir" title="Excluir"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Fim exemplo -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Bootstrap JS Bundle (necessário para modal funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
