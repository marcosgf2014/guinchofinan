<?php
include __DIR__ . '/../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM checklist WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        header('Location: index.php?msg=Checklist excluído com sucesso!');
        exit;
    } else {
        header('Location: index.php?msg=Erro ao excluir checklist!');
        exit;
    }
    $stmt->close();
}
$conn->close();
?>
