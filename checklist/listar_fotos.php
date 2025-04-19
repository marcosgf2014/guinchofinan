<?php
header('Content-Type: application/json');
require_once '../db.php';

$fotos = [];
if (isset($_GET['checklist_id']) && is_numeric($_GET['checklist_id'])) {
    $checklist_id = (int)$_GET['checklist_id'];
    $stmt = $conn->prepare('SELECT id, caminho FROM checklist_fotos WHERE checklist_id = ? ORDER BY id ASC');
    $stmt->bind_param('i', $checklist_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $fotos[] = [
            'id' => $row['id'],
            'caminho' => $row['caminho']
        ];
    }
    $stmt->close();
}
echo json_encode(['fotos' => $fotos]);
