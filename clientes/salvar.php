<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome'] ?? '');
    $cpf_cnpj = $conn->real_escape_string($_POST['cpf_cnpj'] ?? '');
    $telefone = $conn->real_escape_string($_POST['telefone'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $endereco = $conn->real_escape_string($_POST['endereco'] ?? '');
    if ($nome) {
        $sql = "INSERT INTO clientes (nome, cpf_cnpj, telefone, email, endereco) VALUES ('$nome', '$cpf_cnpj', '$telefone', '$email', '$endereco')";
        $conn->query($sql);
    }
    header('Location: index.php');
    exit;
}
?>
