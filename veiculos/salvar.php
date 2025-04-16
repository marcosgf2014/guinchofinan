<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $conn->real_escape_string($_POST['placa'] ?? '');
    $modelo = $conn->real_escape_string($_POST['modelo'] ?? '');
    $cor = $conn->real_escape_string($_POST['cor'] ?? '');
    $cliente = $conn->real_escape_string($_POST['cliente'] ?? '');
    $cliente_id = null;
    if ($cliente) {
        $res = $conn->query("SELECT id FROM clientes WHERE nome = '$cliente' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $cliente_id = $row['id'];
        }
    }
    if ($placa && $cliente_id) {
        $sql = "INSERT INTO veiculos (cliente_id, placa, modelo, cor) VALUES ($cliente_id, '$placa', '$modelo', '$cor')";
        $conn->query($sql);
    }
    header('Location: index.php');
    exit;
}
?>
