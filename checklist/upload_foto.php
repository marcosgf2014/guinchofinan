<?php
require_once '../db.php';

if (!isset($_POST['checklist_id'])) {
    echo json_encode(['success' => false, 'message' => 'Checklist não informado.']);
    exit;
}

$checklist_id = intval($_POST['checklist_id']);
$respostas = [];
$upload_dir = '../uploads/checklist_fotos/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES['fotos']['name'][0])) {
    foreach ($_FILES['fotos']['tmp_name'] as $i => $tmp_name) {
        if ($_FILES['fotos']['error'][$i] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['fotos']['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid('foto_', true) . '.' . $ext;
            $dest_path = $upload_dir . $filename;
            if (move_uploaded_file($tmp_name, $dest_path)) {
                // Salva no banco
                $stmt = $conn->prepare('INSERT INTO checklist_fotos (checklist_id, caminho) VALUES (?, ?)');
                $db_path = 'checklist_fotos/' . $filename;
                $stmt->bind_param('is', $checklist_id, $db_path);
                $stmt->execute();
                $stmt->close();
                $respostas[] = $db_path;
            }
        }
    }
    echo json_encode(['success' => true, 'fotos' => $respostas]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhuma foto enviada.']);
}
$conn->close();
