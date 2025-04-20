<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$msg = '';
if (isset($_SESSION['troca_error'])) {
    $msg = $_SESSION['troca_error'];
    unset($_SESSION['troca_error']);
}
if (isset($_SESSION['troca_success'])) {
    $msg = $_SESSION['troca_success'];
    unset($_SESSION['troca_success']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Login e Senha</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Trocar Login e Senha</h2>
        <?php if ($msg): ?>
            <div class="<?= strpos($msg, 'sucesso') !== false ? 'success' : 'error' ?>"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <form action="troca_login_senha_processa.php" method="post">
            <div class="form-group">
                <label for="novo_login">Novo Usuário</label>
                <input type="text" id="novo_login" name="novo_login" required autofocus>
            </div>
            <div class="form-group">
                <label for="nova_senha">Nova Senha</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
            </div>
            <div class="form-group">
                <label for="confirma_senha">Confirme a Nova Senha</label>
                <input type="password" id="confirma_senha" name="confirma_senha" required>
            </div>
            <button type="submit" class="btn">Salvar</button>
        </form>
    </div>
</body>
</html>
