<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $conn->real_escape_string($_POST['cliente'] ?? '');
    $veiculo = $conn->real_escape_string($_POST['veiculo'] ?? '');
    $data = $conn->real_escape_string($_POST['data'] ?? '');
    $valor = $conn->real_escape_string($_POST['valor'] ?? '');
    $descricao = $conn->real_escape_string($_POST['descricao'] ?? '');
    $tipo = $conn->real_escape_string($_POST['tipo'] ?? 'entrada');
    $cliente_id = 'NULL';
    $veiculo_id = 'NULL';
    if ($cliente) {
        $res = $conn->query("SELECT id FROM clientes WHERE nome = '$cliente' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $cliente_id = $row['id'];
        }
    }
    if ($veiculo) {
        $res = $conn->query("SELECT id FROM veiculos WHERE placa = '$veiculo' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $veiculo_id = $row['id'];
        }
    }
    if ($data && $valor && $tipo) {
        $sql = "INSERT INTO financeiro (cliente_id, veiculo_id, data, valor, descricao, tipo) VALUES ($cliente_id, $veiculo_id, '$data', '$valor', '$descricao', '$tipo')";
        $conn->query($sql);
    }
    header('Location: index.php');
    exit;
}
?>
