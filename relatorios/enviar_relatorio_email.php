<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Recebe o PDF (base64) e o e-mail de destino via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pdfBase64 = $_POST['pdf'] ?? '';
    if (!$email || !$pdfBase64) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
        exit;
    }

    // Decodifica o PDF
    $pdfData = base64_decode(preg_replace('#^data:application/pdf;base64,#i', '', $pdfBase64));
    $tmpPdf = tempnam(sys_get_temp_dir(), 'relatorio_') . '.pdf';
    file_put_contents($tmpPdf, $pdfData);

    // Envia o e-mail (PHPMailer)
    require '../vendor/autoload.php';
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);
    try {
        // Configuração SMTP (ajuste para seu provedor)
        $mail->isSMTP();
        $mail->Host = 'smtp.seudominio.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'seu@email.com';
        $mail->Password = 'sua_senha';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('seu@email.com', 'Relatórios Guincho');
        $mail->addAddress($email);
        $mail->Subject = 'Relatório Financeiro';
        $mail->Body = 'Segue em anexo o relatório financeiro em PDF.';
        $mail->addAttachment($tmpPdf, 'relatorio.pdf');

        $mail->send();
        unlink($tmpPdf);
        echo json_encode(['success' => true, 'message' => 'E-mail enviado com sucesso!']);
    } catch (Exception $e) {
        unlink($tmpPdf);
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao enviar e-mail: ' . $mail->ErrorInfo]);
    }
    exit;
}
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
