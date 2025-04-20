<?php
include __DIR__ . '/../db.php';

$cliente = $_POST['cliente'] ?? '';
$origem = $_POST['origem'] ?? '';
$destino = $_POST['destino'] ?? '';
$veiculo = $_POST['veiculo'] ?? '';
$data_entrada = $_POST['entrada'] ?? '';
$quilometragem = $_POST['quilometragem'] ?? '';
$nivel_combustivel = $_POST['combustivel'] ?? '';
$danos_externos = isset($_POST['danos_externos']) ? 1 : 0;
$pertences = $_POST['pertences'] ?? '';
$observacoes = $_POST['observacoes'] ?? '';

$pneus_dianteiros = $_POST['pneus_dianteiros'] ?? '';
$pneus_traseiros = $_POST['pneus_traseiros'] ?? '';
$rodas_dianteiras = $_POST['rodas_dianteiras'] ?? '';
$rodas_traseiras = $_POST['rodas_traseiras'] ?? '';

$calotas = isset($_POST['calotas']) ? 1 : 0;
$retrovisores = isset($_POST['retrovisores']) ? 1 : 0;
$palhetas = isset($_POST['palhetas']) ? 1 : 0;
$triangulo = isset($_POST['triangulo']) ? 1 : 0;
$macaco_chave = isset($_POST['macaco_chave']) ? 1 : 0;
$estepe = isset($_POST['estepe']) ? 1 : 0;

$bancos = isset($_POST['bancos']) ? 1 : 0;
$painel = isset($_POST['painel']) ? 1 : 0;
$consoles = isset($_POST['consoles']) ? 1 : 0;
$forracao = isset($_POST['forracao']) ? 1 : 0;
$tapetes = isset($_POST['tapetes']) ? 1 : 0;

$bateria = isset($_POST['bateria']) ? 1 : 0;
$chaves = isset($_POST['chaves']) ? 1 : 0;
$documentos = isset($_POST['documentos']) ? 1 : 0;
$som = isset($_POST['som']) ? 1 : 0;
$caixa_selada = isset($_POST['caixa_selada']) ? 1 : 0;

// Fotos e assinaturas (apenas nomes dos arquivos)
$fotos = isset($_FILES['fotos']) ? json_encode($_FILES['fotos']['name']) : '';
$assinatura_cliente = $_FILES['assinatura_cliente']['name'] ?? '';
$assinatura_responsavel = $_FILES['assinatura_responsavel']['name'] ?? '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // UPDATE
    $id = intval($_GET['id']);
    $sql = "UPDATE checklist SET
        cliente=?, origem=?, destino=?, veiculo=?, data_entrada=?, quilometragem=?, nivel_combustivel=?, danos_externos=?, pertences=?, observacoes=?,
        pneus_dianteiros=?, pneus_traseiros=?, rodas_dianteiras=?, rodas_traseiras=?,
        calotas=?, retrovisores=?, palhetas=?, triangulo=?, macaco_chave=?, estepe=?,
        bancos=?, painel=?, consoles=?, forracao=?, tapetes=?,
        bateria=?, chaves=?, documentos=?, som=?, caixa_selada=?,
        fotos=?, assinatura_cliente=?, assinatura_responsavel=?
        WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssissssssiiiiiiiiiiiiiiiiissssi',
        $cliente, $origem, $destino, $veiculo, $data_entrada, $quilometragem, $nivel_combustivel, $danos_externos, $pertences, $observacoes,
        $pneus_dianteiros, $pneus_traseiros, $rodas_dianteiras, $rodas_traseiras,
        $calotas, $retrovisores, $palhetas, $triangulo, $macaco_chave, $estepe,
        $bancos, $painel, $consoles, $forracao, $tapetes,
        $bateria, $chaves, $documentos, $som, $caixa_selada,
        $fotos, $assinatura_cliente, $assinatura_responsavel,
        $id
    );
    if ($stmt->execute()) {
        header('Location: index.php?msg=Checklist atualizado com sucesso!');
        exit;
    } else {
        header('Location: index.php?msg=Erro ao atualizar checklist!');
        exit;
    }
    $stmt->close();
} else {
    // INSERT
    $sql = "INSERT INTO checklist (
        cliente, origem, destino, veiculo, data_entrada, quilometragem, nivel_combustivel, danos_externos, pertences, observacoes,
        pneus_dianteiros, pneus_traseiros, rodas_dianteiras, rodas_traseiras,
        calotas, retrovisores, palhetas, triangulo, macaco_chave, estepe,
        bancos, painel, consoles, forracao, tapetes,
        bateria, chaves, documentos, som, caixa_selada,
        fotos, assinatura_cliente, assinatura_responsavel
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
    )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssissssssiiiiiiiiiiiiiiiiissss',
        $cliente, $origem, $destino, $veiculo, $data_entrada, $quilometragem, $nivel_combustivel, $danos_externos, $pertences, $observacoes,
        $pneus_dianteiros, $pneus_traseiros, $rodas_dianteiras, $rodas_traseiras,
        $calotas, $retrovisores, $palhetas, $triangulo, $macaco_chave, $estepe,
        $bancos, $painel, $consoles, $forracao, $tapetes,
        $bateria, $chaves, $documentos, $som, $caixa_selada,
        $fotos, $assinatura_cliente, $assinatura_responsavel
    );
    if ($stmt->execute()) {
        header('Location: index.php?msg=Checklist salvo com sucesso!');
        exit;
    } else {
        header('Location: index.php?msg=Erro ao salvar checklist!');
        exit;
    }
    $stmt->close();
}
$conn->close();
?>
