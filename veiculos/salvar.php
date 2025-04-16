<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização
    $cliente_id    = (int) ($_POST['cliente_id'] ?? 0);
    $tipo_veiculo  = $conn->real_escape_string($_POST['tipo_veiculo'] ?? '');
    $placa         = $conn->real_escape_string(strtoupper($_POST['placa'] ?? ''));
    $modelo        = $conn->real_escape_string($_POST['modelo'] ?? '');
    $ano           = (int) ($_POST['ano'] ?? 0);
    $cor           = $conn->real_escape_string($_POST['cor'] ?? '');
    $status        = $conn->real_escape_string($_POST['status'] ?? '');
    $valor_servico = floatval(str_replace([','], ['.'], $_POST['valor_servico'] ?? '0'));
    $data_entrada  = $conn->real_escape_string($_POST['data_entrada'] ?? '');
    $hora_entrada  = $conn->real_escape_string($_POST['hora_entrada'] ?? '');
    $data_saida    = $conn->real_escape_string($_POST['data_saida'] ?? '');
    $hora_saida    = $conn->real_escape_string($_POST['hora_saida'] ?? '');
    $origem        = $conn->real_escape_string($_POST['origem'] ?? '');
    $destino       = $conn->real_escape_string($_POST['destino'] ?? '');
    $obs           = $conn->real_escape_string($_POST['obs'] ?? '');

    // Validação de campos obrigatórios
    if ($cliente_id && $tipo_veiculo && $placa && $status && $valor_servico && $data_entrada && $hora_entrada) {
        $sql = "INSERT INTO veiculos (
            cliente_id, tipo_veiculo, placa, modelo, ano, cor, status, valor_servico,
            data_entrada, hora_entrada, data_saida, hora_saida, origem, destino, obs
        ) VALUES (
            $cliente_id, '$tipo_veiculo', '$placa', '$modelo',
            $ano, '$cor', '$status', $valor_servico,
            '$data_entrada', '$hora_entrada',
            " . ($data_saida ? "'$data_saida'" : 'NULL') . ",
            " . ($hora_saida ? "'$hora_saida'" : 'NULL') . ",
            '$origem', '$destino', '$obs'
        )";
        if ($conn->query($sql)) {
            header('Location: index.php?msg=Veículo cadastrado com sucesso!&type=success');
            exit;
        } else {
            header('Location: index.php?msg=Erro ao cadastrar veículo!&type=danger');
            exit;
        }
    } else {
        header('Location: index.php?msg=Preencha todos os campos obrigatórios!&type=warning');
        exit;
    }
}
?>
