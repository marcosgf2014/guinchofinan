<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$novo_login = $_POST['novo_login'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirma_senha = $_POST['confirma_senha'] ?? '';

if (!$novo_login || !$nova_senha || !$confirma_senha) {
    $_SESSION['troca_error'] = 'Preencha todos os campos.';
    header('Location: troca_login_senha.php');
    exit;
}

if ($nova_senha !== $confirma_senha) {
    $_SESSION['troca_error'] = 'As senhas não coincidem.';
    header('Location: troca_login_senha.php');
    exit;
}

// Verifica se o novo login já existe para outro usuário
$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE login = ? AND id != ?');
$stmt->execute([$novo_login, $_SESSION['usuario_id']]);
if ($stmt->fetch()) {
    $_SESSION['troca_error'] = 'Este usuário já existe.';
    header('Location: troca_login_senha.php');
    exit;
}

// Atualiza login e senha
$hash = password_hash($nova_senha, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('UPDATE usuarios SET login = ?, senha = ?, senha_temporaria = 0 WHERE id = ?');
$stmt->execute([$novo_login, $hash, $_SESSION['usuario_id']]);

$_SESSION['usuario_login'] = $novo_login;
$_SESSION['troca_success'] = 'Login e senha alterados com sucesso!';
header('Location: dashboard.php');
exit;
