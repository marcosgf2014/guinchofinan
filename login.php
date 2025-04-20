<?php
session_start();
require_once 'conexao.php';

$login = trim($_POST['login'] ?? '');
$senha = $_POST['senha'] ?? '';

// Debug: registrar login, senha, resultado do select e do password_verify
$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE login = ? LIMIT 1');
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$senha_correta = $user ? password_verify($senha, $user['senha']) : false;
file_put_contents('debug_login.txt', print_r([
    'login_digitado' => $login,
    'senha_digitada' => $senha,
    'user_encontrado' => $user,
    'senha_hash' => $user['senha'] ?? null,
    'password_verify' => $senha_correta
], true));

if (!$login || !$senha) {
    $_SESSION['login_error'] = 'Preencha todos os campos.';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE login = ? LIMIT 1');
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_login'] = $user['login'];
    if ($user['senha_temporaria']) {
        header('Location: troca_login_senha.php');
        exit;
    } else {
        header('Location: dashboard.php');
        exit;
    }
} else {
    $_SESSION['login_error'] = 'Usuário ou senha inválidos.';
    header('Location: index.php');
    exit;
}
