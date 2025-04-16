<?php
require_once '../db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM clientes WHERE id = $id";
    if ($conn->query($sql)) {
        header('Location: index.php?msg=Cliente excluído com sucesso!&type=success');
        exit;
    } else {
        header('Location: index.php?msg=Erro ao excluir cliente.&type=danger');
        exit;
    }
} else {
    header('Location: index.php?msg=ID inválido.&type=danger');
    exit;
}
