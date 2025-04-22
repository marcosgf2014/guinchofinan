<?php
require_once '../db.php';
// Log para depuração
error_log('ID recebido para exclusão: ' . ($_GET['id'] ?? 'NULO'));

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM veiculos WHERE id = $id");
    header('Location: index.php?msg=Veículo excluído com sucesso!&type=success');
    exit;
} else {
    header('Location: index.php?msg=ID inválido!&type=danger');
    exit;
}
