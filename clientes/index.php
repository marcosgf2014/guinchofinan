<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes | Guincho</title>
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
            <a href="index.php" class="active"><i class="fas fa-users"></i> Clientes</a>
            <a href="../veiculos/index.php"><i class="fas fa-car"></i> Veículos</a>
            <a href="../financeiro/index.php"><i class="fas fa-coins"></i> Financeiro</a>
        </nav>
    </aside>
    <main class="main-content container py-4">
        <h1 class="mb-4"><i class="fas fa-users"></i> Clientes</h1>
        <div class="row mb-4">
            <div class="col-md-8">
                <form class="d-flex" method="get" action="index.php">
                    <input class="form-control me-2" type="search" name="busca" placeholder="Buscar por nome ou CPF/CNPJ" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalCadastroCliente">
                    <i class="fas fa-plus"></i> Adicionar Cliente
                </button>
            </div>
        </div>

        <!-- Modal Cadastro Cliente -->
        <div class="modal fade" id="modalCadastroCliente" tabindex="-1" aria-labelledby="modalCadastroClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastroClienteLabel"><i class="fas fa-user-plus"></i> Novo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form class="row g-3 p-3" method="post" action="salvar.php">
                        <div class="col-md-12">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" placeholder="CPF ou CNPJ">
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section>
            <h2 class="mb-3"><i class="fas fa-list"></i> Lista de Clientes</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../db.php';
                        $where = '';
                        if (isset($_GET['busca']) && trim($_GET['busca']) !== '') {
                            $busca = $conn->real_escape_string($_GET['busca']);
                            $where = "WHERE nome LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%'";
                        }
                        $res = $conn->query("SELECT * FROM clientes $where ORDER BY nome ASC");
                        if ($res && $res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
                                echo '<td>' . (isset($row['cpf_cnpj']) ? htmlspecialchars($row['cpf_cnpj']) : '-') . '</td>';
                                echo '<td>' . (isset($row['telefone']) ? htmlspecialchars($row['telefone']) : '-') . '</td>';
                                echo '<td>' . (isset($row['email']) ? htmlspecialchars($row['email']) : '-') . '</td>';
                                echo '<td>' . (isset($row['endereco']) ? htmlspecialchars($row['endereco']) : '-') . '</td>';
                                echo '<td class="text-center">';
                                echo '<a href="#" class="btn btn-sm btn-primary me-1" title="Editar"><i class="fas fa-edit"></i></a>';
                                echo '<a href="#" class="btn btn-sm btn-danger" title="Excluir"><i class="fas fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">Nenhum cliente cadastrado ainda.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Bootstrap JS (opcional, para componentes interativos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
