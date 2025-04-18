<?php
require_once '../db.php';

function checkboxToInt($field) {
    return isset($_POST[$field]) ? 1 : 0;
}

// Coleta dos campos do formulário
$cliente = isset($_POST['cliente']) ? $conn->real_escape_string($_POST['cliente']) : '';
$veiculo = isset($_POST['veiculo']) ? $conn->real_escape_string($_POST['veiculo']) : '';
$entrada = isset($_POST['entrada']) ? $conn->real_escape_string($_POST['entrada']) : '';
$origem = isset($_POST['origem']) ? $conn->real_escape_string($_POST['origem']) : '';
$destino = isset($_POST['destino']) ? $conn->real_escape_string($_POST['destino']) : '';
$quilometragem = isset($_POST['quilometragem']) && $_POST['quilometragem'] !== '' ? (int)$_POST['quilometragem'] : 'NULL';
$combustivel = isset($_POST['combustivel']) ? $conn->real_escape_string($_POST['combustivel']) : '';
$pneus_dianteiros = isset($_POST['pneus_dianteiros']) ? $conn->real_escape_string($_POST['pneus_dianteiros']) : '';
$pneus_traseiros = isset($_POST['pneus_traseiros']) ? $conn->real_escape_string($_POST['pneus_traseiros']) : '';
$rodas_dianteiras = isset($_POST['rodas_dianteiras']) ? $conn->real_escape_string($_POST['rodas_dianteiras']) : '';
$rodas_traseiras = isset($_POST['rodas_traseiras']) ? $conn->real_escape_string($_POST['rodas_traseiras']) : '';
$observacoes = isset($_POST['observacoes']) ? $conn->real_escape_string($_POST['observacoes']) : '';
$pertences = isset($_POST['pertences']) ? $conn->real_escape_string($_POST['pertences']) : '';
$danos = checkboxToInt('danos');

// Acessórios e demais checkboxes
$calotas = checkboxToInt('calotas');
$retrovisores = checkboxToInt('retrovisores');
$palhetas = checkboxToInt('palhetas');
$triangulo = checkboxToInt('triangulo');
$macaco = checkboxToInt('macaco');
$estepe = checkboxToInt('estepe');
$bancos = checkboxToInt('bancos');
$painel = checkboxToInt('painel');
$consoles = checkboxToInt('consoles');
$forracao = checkboxToInt('forracao');
$tapetes = checkboxToInt('tapetes');
$bateria = checkboxToInt('bateria');
$chaves = checkboxToInt('chaves');
$documentos = checkboxToInt('documentos');
$som = checkboxToInt('som');
$caixa_selada = checkboxToInt('caixa_selada');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int)$_POST['id'];
    $sql = "UPDATE checklist SET 
        cliente='$cliente', veiculo='$veiculo', entrada='$entrada', origem='$origem', destino='$destino', quilometragem=".($quilometragem === 'NULL' ? "NULL" : $quilometragem).", combustivel='$combustivel', pneus_dianteiros='$pneus_dianteiros', pneus_traseiros='$pneus_traseiros', rodas_dianteiras='$rodas_dianteiras', rodas_traseiras='$rodas_traseiras', observacoes='$observacoes', pertences='$pertences', danos=$danos,
        calotas=$calotas, retrovisores=$retrovisores, palhetas=$palhetas, triangulo=$triangulo, macaco=$macaco, estepe=$estepe, bancos=$bancos, painel=$painel, consoles=$consoles, forracao=$forracao, tapetes=$tapetes, bateria=$bateria, chaves=$chaves, documentos=$documentos, som=$som, caixa_selada=$caixa_selada
        WHERE id=$id";
} else {
    $sql = "INSERT INTO checklist (
        cliente, veiculo, entrada, origem, destino, quilometragem, combustivel, pneus_dianteiros, pneus_traseiros, rodas_dianteiras, rodas_traseiras, observacoes, pertences, danos,
        calotas, retrovisores, palhetas, triangulo, macaco, estepe, bancos, painel, consoles, forracao, tapetes, bateria, chaves, documentos, som, caixa_selada
    ) VALUES (
        '$cliente', '$veiculo', '$entrada', '$origem', '$destino', ".($quilometragem === 'NULL' ? "NULL" : $quilometragem).", '$combustivel', '$pneus_dianteiros', '$pneus_traseiros', '$rodas_dianteiras', '$rodas_traseiras', '$observacoes', '$pertences', $danos,
        $calotas, $retrovisores, $palhetas, $triangulo, $macaco, $estepe, $bancos, $painel, $consoles, $forracao, $tapetes, $bateria, $chaves, $documentos, $som, $caixa_selada
    )";
}

if ($conn->query($sql)) {
    header('Location: index.php?msg=checklist_salvo');
    exit;
} else {
    echo '<div style="padding:2rem;text-align:center;color:red;"><h2>Erro ao salvar checklist!</h2><p>'.$conn->error.'</p><a href="javascript:history.back()">Voltar</a></div>';
}
$conn->close();
