<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nome = $conn->real_escape_string($_POST['nome'] ?? '');
    $cpf_cnpj = $conn->real_escape_string($_POST['cpf_cnpj'] ?? '');
    $telefone = $conn->real_escape_string($_POST['telefone'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $endereco = $conn->real_escape_string($_POST['endereco'] ?? '');
    if ($id > 0 && $nome) {
        // Validação de duplicidade de CPF/CNPJ
        if ($cpf_cnpj !== '') {
            $sqlCheck = "SELECT id FROM clientes WHERE cpf_cnpj = '$cpf_cnpj' AND id != $id LIMIT 1";
            $resCheck = $conn->query($sqlCheck);
            if ($resCheck && $resCheck->num_rows > 0) {
                header('Location: index.php?msg=CPF/CNPJ já cadastrado em outro cliente!&type=danger');
                exit;
            }
        }
        $sql = "UPDATE clientes SET nome='$nome', cpf_cnpj='$cpf_cnpj', telefone='$telefone', email='$email', endereco='$endereco' WHERE id=$id";
        if ($conn->query($sql)) {
            header('Location: index.php?msg=Cliente atualizado com sucesso!&type=success');
            exit;
        } else {
            header('Location: index.php?msg=Erro ao atualizar cliente.&type=danger');
            exit;
        }
    }
    header('Location: index.php?msg=Dados inválidos para edição.&type=danger');
    exit;
}
?>
