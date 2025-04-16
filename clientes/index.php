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
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-<?php echo isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>
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
                                echo '<a href="#" class="btn btn-sm btn-primary me-1 btn-editar" title="Editar" 
    data-id="' . $row['id'] . '" 
    data-nome="' . htmlspecialchars($row['nome'], ENT_QUOTES) . '" 
    data-cpf_cnpj="' . htmlspecialchars($row['cpf_cnpj'], ENT_QUOTES) . '" 
    data-telefone="' . htmlspecialchars($row['telefone'], ENT_QUOTES) . '" 
    data-email="' . htmlspecialchars($row['email'], ENT_QUOTES) . '" 
    data-endereco="' . htmlspecialchars($row['endereco'], ENT_QUOTES) . '"><i class="fas fa-edit"></i></a>';
                                echo '<a href="excluir.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger btn-excluir" title="Excluir"><i class="fas fa-trash"></i></a>';
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
    <!-- Modal Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarClienteLabel"><i class="fas fa-user-edit"></i> Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <form class="row g-3 p-3" method="post" action="editar.php" id="formEditarCliente">
        <input type="hidden" name="id" id="editar_id">
        <div class="col-md-12">
          <label for="editar_nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="editar_nome" name="nome" placeholder="Nome completo" required>
        </div>
        <div class="col-md-6">
          <label for="editar_cpf_cnpj" class="form-label">CPF/CNPJ</label>
          <input type="text" class="form-control" id="editar_cpf_cnpj" name="cpf_cnpj" placeholder="CPF ou CNPJ">
        </div>
        <div class="col-md-6">
          <label for="editar_telefone" class="form-label">Telefone</label>
          <input type="text" class="form-control" id="editar_telefone" name="telefone" placeholder="Telefone">
        </div>
        <div class="col-md-6">
          <label for="editar_email" class="form-label">Email</label>
          <input type="email" class="form-control" id="editar_email" name="email" placeholder="Email">
        </div>
        <div class="col-md-6">
          <label for="editar_endereco" class="form-label">Endereço</label>
          <input type="text" class="form-control" id="editar_endereco" name="endereco" placeholder="Endereço">
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save"></i> Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>
</main>
<script>
// Confirmação de exclusão
    document.addEventListener('DOMContentLoaded', function() {
        const excluirLinks = document.querySelectorAll('.btn-excluir');
        excluirLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                if (!confirm('Tem certeza que deseja excluir este cliente?')) {
                    event.preventDefault();
                }
            });
        });
        // Preencher modal de edição
        const editarLinks = document.querySelectorAll('.btn-editar');
        editarLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('editar_id').value = this.getAttribute('data-id');
                document.getElementById('editar_nome').value = this.getAttribute('data-nome');
                document.getElementById('editar_cpf_cnpj').value = this.getAttribute('data-cpf_cnpj');
                document.getElementById('editar_telefone').value = this.getAttribute('data-telefone');
                document.getElementById('editar_email').value = this.getAttribute('data-email');
                document.getElementById('editar_endereco').value = this.getAttribute('data-endereco');
                var modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                modal.show();
            });
        });
        // Máscara dinâmica de CPF/CNPJ
        function aplicarMascaraCpfCnpj(input) {
            input.addEventListener('input', function(e) {
                let v = input.value.replace(/\D/g, '');
                if (v.length <= 11) {
                    // CPF: 000.000.000-00
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                } else {
                    // CNPJ: 00.000.000/0000-00
                    v = v.replace(/(\d{2})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1/$2');
                    v = v.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
                }
                input.value = v;
            });
        }
        aplicarMascaraCpfCnpj(document.getElementById('cpf_cnpj'));
        aplicarMascaraCpfCnpj(document.getElementById('editar_cpf_cnpj'));
        // Máscara telefone
        function aplicarMascaraTelefone(input) {
            input.addEventListener('input', function(e) {
                let v = input.value.replace(/\D/g, '');
                if (v.length > 11) v = v.slice(0, 11);
                if (v.length > 6 && v.length <= 10) {
                    // Fixo ou celular antigo: (XX) XXXX-XXXX
                    v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else if (v.length > 10) {
                    // Celular novo: (XX) XXXXX-XXXX
                    v = v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                } else if (v.length > 2) {
                    v = v.replace(/(\d{2})(\d{0,9})/, '($1) $2');
                } else {
                    v = v.replace(/(\d{0,2})/, '($1');
                }
                input.value = v.trim();
            });
        }
        aplicarMascaraTelefone(document.getElementById('telefone'));
        aplicarMascaraTelefone(document.getElementById('editar_telefone'));

        // Validação simples de CPF/CNPJ (apenas formato, não dígito)
        function validarCpfCnpj(valor) {
            valor = valor.replace(/\D/g, '');
            if (valor.length === 11) return true; // CPF
            if (valor.length === 14) return true; // CNPJ
            return false;
        }
        document.getElementById('cpf_cnpj').addEventListener('blur', function() {
            if (this.value && !validarCpfCnpj(this.value)) {
                alert('CPF ou CNPJ inválido!');
                this.focus();
            }
        });
        document.getElementById('editar_cpf_cnpj').addEventListener('blur', function() {
            if (this.value && !validarCpfCnpj(this.value)) {
                alert('CPF ou CNPJ inválido!');
                this.focus();
            }
        });
    });
</script>
    <!-- Bootstrap JS (opcional, para componentes interativos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Confirmação de exclusão
    document.addEventListener('DOMContentLoaded', function() {
        const excluirLinks = document.querySelectorAll('.btn-excluir');
        excluirLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                if (!confirm('Tem certeza que deseja excluir este cliente?')) {
                    event.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>
