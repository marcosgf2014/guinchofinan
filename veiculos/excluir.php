<?php
require_once '../db.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM veiculos WHERE id = $id");
    header('Location: index.php?msg=Veículo excluído com sucesso!&type=success');
    exit;
} else {
    header('Location: index.php?msg=ID inválido!&type=danger');
    exit;
}
