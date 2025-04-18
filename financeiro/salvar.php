<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $conn->real_escape_string($_POST['tipo'] ?? 'entrada');
    $categoria = $conn->real_escape_string($_POST['categoria'] ?? '');
    $data = $conn->real_escape_string($_POST['data'] ?? '');
    $descricao = $conn->real_escape_string($_POST['descricao'] ?? '');
    $valor = $conn->real_escape_string($_POST['valor'] ?? '');
    $pagamento = $conn->real_escape_string($_POST['pagamento'] ?? '');
    $nota_fiscal = $conn->real_escape_string($_POST['nota_fiscal'] ?? '');
    $id_lancamento = $conn->real_escape_string($_POST['id_lancamento'] ?? '');
    if ($data && $valor && $tipo) {
        if ($id_lancamento) {
            $sql = "UPDATE financeiro SET tipo='$tipo', categoria='$categoria', data='$data', descricao='$descricao', valor='$valor', pagamento='$pagamento', nota_fiscal='$nota_fiscal' WHERE id='$id_lancamento'";
        } else {
            $sql = "INSERT INTO financeiro (tipo, categoria, data, descricao, valor, pagamento, nota_fiscal) VALUES ('$tipo', '$categoria', '$data', '$descricao', '$valor', '$pagamento', '$nota_fiscal')";
        }
        $conn->query($sql);
    }
    header('Location: index.php');
    exit;
}
?>
