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
    <link rel="stylesheet" href="assets/login-card.css">
</head>
<body>
    <div class="login-card">
        <h2>Entrar no Sistema</h2>
        <?php if ($msg): ?>
            <div class="error" style="color: #d32f2f; margin-bottom: 16px;"> <?= htmlspecialchars($msg) ?> </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="login">Usuário</label>
            <input type="text" id="login" name="login" autocomplete="off" required autofocus>
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
