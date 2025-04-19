<?php
require_once '../db.php';
header('Content-Type: application/json');

$cliente = isset($_GET['cliente']) ? $conn->real_escape_string($_GET['cliente']) : '';
$veiculo = isset($_GET['veiculo']) ? $conn->real_escape_string($_GET['veiculo']) : '';

if (!$cliente || !$veiculo) {
    echo json_encode(['success' => false, 'error' => 'Dados insuficientes.']);
    exit;
}

// Buscar ID do cliente
$resCliente = $conn->query("SELECT id FROM clientes WHERE nome = '$cliente' LIMIT 1");
if ($resCliente && $resCliente->num_rows > 0) {
    $clienteRow = $resCliente->fetch_assoc();
    $clienteId = $clienteRow['id'];

    // Buscar origem e destino do veículo
    $resVeiculo = $conn->query("SELECT origem, destino FROM veiculos WHERE cliente_id = $clienteId AND CONCAT(modelo, ' - ', placa) = '$veiculo' LIMIT 1");
    if ($resVeiculo && $resVeiculo->num_rows > 0) {
        $veiculoRow = $resVeiculo->fetch_assoc();
        echo json_encode([
            'success' => true,
            'origem' => $veiculoRow['origem'],
            'destino' => $veiculoRow['destino']
        ]);
        exit;
    }
}
echo json_encode(['success' => false, 'error' => 'Veículo não encontrado.']);
