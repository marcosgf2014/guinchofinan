<?php
session_start();
$msg = '';
if (isset($_SESSION['login_error'])) {
    $msg = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Guinchofinan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Entrar no Sistema</h2>
        <?php if ($msg): ?>
            <div class="error"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="login">Usuário</label>
                <input type="text" id="login" name="login" required autofocus>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>
    </div>
</body>
</html>
