<?php
require_once '../db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?msg=erro_id');
    exit;
}
$id = (int)$_GET['id'];
$sql = "DELETE FROM financeiro WHERE id = $id";
if ($conn->query($sql)) {
    header('Location: index.php?msg=financeiro_excluido');
    exit;
} else {
    echo '<div style="padding:2rem;text-align:center;color:red;"><h2>Erro ao excluir lançamento!</h2><p>'.$conn->error.'</p><a href="index.php">Voltar</a></div>';
}
$conn->close();
