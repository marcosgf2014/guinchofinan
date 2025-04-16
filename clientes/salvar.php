<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome'] ?? '');
    $cpf_cnpj = $conn->real_escape_string($_POST['cpf_cnpj'] ?? '');
    $telefone = $conn->real_escape_string($_POST['telefone'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $endereco = $conn->real_escape_string($_POST['endereco'] ?? '');
    if ($nome) {
        // Validação de duplicidade de CPF/CNPJ
        if ($cpf_cnpj !== '') {
            $sqlCheck = "SELECT id FROM clientes WHERE cpf_cnpj = '$cpf_cnpj' LIMIT 1";
            $resCheck = $conn->query($sqlCheck);
            if ($resCheck && $resCheck->num_rows > 0) {
                header('Location: index.php?msg=CPF/CNPJ já cadastrado!&type=danger');
                exit;
            }
        }
        $sql = "INSERT INTO clientes (nome, cpf_cnpj, telefone, email, endereco) VALUES ('$nome', '$cpf_cnpj', '$telefone', '$email', '$endereco')";
        $conn->query($sql);
        header('Location: index.php?msg=Cliente cadastrado com sucesso!&type=success');
        exit;
    }
    header('Location: index.php?msg=Preencha o nome do cliente.&type=danger');
    exit;
}
?>
