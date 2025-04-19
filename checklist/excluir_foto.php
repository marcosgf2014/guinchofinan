<?php
header('Content-Type: application/json');
require_once '../db.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}
$id = (int)$_POST['id'];

// Busca o caminho da foto
$stmt = $conn->prepare('SELECT caminho FROM checklist_fotos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($caminho);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Foto não encontrada']);
    $stmt->close();
    exit;
}
$stmt->close();

// Remove do banco
$stmt = $conn->prepare('DELETE FROM checklist_fotos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

// Remove o arquivo físico
$arquivo = __DIR__ . '/../uploads/' . $caminho;
if (file_exists($arquivo)) {
    unlink($arquivo);
}
echo json_encode(['success' => true]);
