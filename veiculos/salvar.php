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
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            // Atualizar veículo existente
            $id = (int)$_GET['id'];
            $sql = "UPDATE veiculos SET
                cliente_id = $cliente_id,
                tipo_veiculo = '$tipo_veiculo',
                placa = '$placa',
                modelo = '$modelo',
                ano = $ano,
                cor = '$cor',
                status = '$status',
                valor_servico = $valor_servico,
                data_entrada = '$data_entrada',
                hora_entrada = '$hora_entrada',
                data_saida = " . ($data_saida ? "'$data_saida'" : 'NULL') . ",
                hora_saida = " . ($hora_saida ? "'$hora_saida'" : 'NULL') . ",
                origem = '$origem',
                destino = '$destino',
                obs = '$obs'
                WHERE id = $id";
            if ($conn->query($sql)) {
                header('Location: index.php?msg=Veículo atualizado com sucesso!&type=success');
                exit;
            } else {
                header('Location: index.php?msg=Erro ao atualizar veículo!&type=danger');
                exit;
            }
        } else {
            // Inserir novo veículo
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
                // Inserir lançamento financeiro automático
                $descricao_fin = trim(($modelo ? $modelo : $tipo_veiculo) . ' - ' . $placa);
                $valor_fin = floatval($valor_servico);
                $data_fin = date('Y-m-d');
                $sql_fin = "INSERT INTO financeiro (tipo, categoria, data, descricao, valor, pagamento, nota_fiscal) VALUES ('entrada', 'Guincho', '$data_fin', '$descricao_fin', $valor_fin, '', '')";
                $conn->query($sql_fin);
                header('Location: index.php?msg=Veículo cadastrado com sucesso!&type=success');
                exit;
            } else {
                header('Location: index.php?msg=Erro ao cadastrar veículo!&type=danger');
                exit;
            }
        }
    } else {
        header('Location: index.php?msg=Preencha todos os campos obrigatórios!&type=warning');
        exit;
    }
}
?>
