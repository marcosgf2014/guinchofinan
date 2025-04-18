<?php
require_once '../db.php';
header('Content-Type: application/json');
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['erro' => 'ID inválido']);
    exit;
}
$id = (int)$_GET['id'];
$sql = "SELECT * FROM financeiro WHERE id = $id LIMIT 1";
$res = $conn->query($sql);
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['erro' => 'Lançamento não encontrado']);
}
$conn->close();
