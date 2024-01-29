<?php
session_start();

include 'PHPMailer.php';
include 'Exception.php';
include 'SMTP.php';
include 'phpMailerConfiguration.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Em phpligaemail.php
$idmongo = isset($_POST['idmongo']) ? $_POST['idmongo'] : null;
//$idmongo= 'tes34';
$emails = isset($_POST['emails']) ? $_POST['emails'] : null;

// Aqui você pode usar $idmongo e $emails conforme necessário
error_log("Valor recebido de enviodemail.php (idmongo): " . $idmongo);
error_log("E-mails recebidos de enviodemail.php: " . $emails);

function obterLinkCompleto($idteste) {
  //$linkAleatorio = isset($_POST['idmongo']) ? $_POST['idmongo'] : null;
  $linkAleatorio = $idteste;
  error_log("Valor recebido de enviodemail.php: " . $linkAleatorio);

  // Verifica se $linkAleatorio não é vazio antes de adicionar à URL
  if (!empty($linkAleatorio)) {
    $linkCompleto = "http://localhost/projformulario/php/pagina_respostas.php?id=" . urlencode($linkAleatorio);

    // Adiciona um log para depuração
    error_log("Link Completo: " . $linkCompleto);

    return $linkCompleto;
  } else {
    // Podes escolher lidar com o caso de $linkAleatorio vazio de acordo com a tua lógica
    // Aqui, estou a retornar uma string vazia, mas podes ajustar conforme necessário.
    return 'sem link';
  }
}

function enviarEmails($listaEmails, $linkCompleto, $config) {
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = $config['smtp_host'];
  $mail->SMTPAuth = true;
  $mail->Username = $config['smtp_username'];
  $mail->Password = $config['smtp_password'];
  $mail->SMTPSecure = $config['smtp_secure'];
  $mail->Port = $config['smtp_port'];

  $mail->setFrom($config['from_email'], $config['from_name']);

  $emailes = explode(',', $listaEmails);
  $emailsEnviados = [];

  foreach ($emailes as $emails) {
    $email = trim($emails);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      try {
        $mail->addAddress($email);

        $mail->Subject = $config['email_subject'];
        $mail->isHTML(true);
        $mail->Body = sprintf($config['email_body'], $linkCompleto, $linkCompleto);

        if ($mail->send()) {
          $emailsEnviados[] = $email;
        } else {
          throw new Exception('Erro ao enviar o e-mail: ' . $mail->ErrorInfo);
        }
      } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
      } finally {
        $mail->clearAddresses();
      }
    } else {
      echo 'E-mail inválido: ' . htmlspecialchars($email) . '<br>';
    }
  }
  echo 'Emails enviados com sucesso!';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $emailInputado = isset($_POST['emails']) ? $_POST['emails'] : '';

  // Check if any emails are provided
  if (empty($emailInputado)) {
    echo 'Nenhum email fornecido. Por favor, insira pelo menos um email.';
  } else {
    $linkCompleto = obterLinkCompleto($idmongo);
    $_SESSION['link'] = $linkCompleto;
    
    try {
      enviarEmails($emailInputado, $linkCompleto, $config);
    } catch (Exception $e) {
      echo 'Erro: ' . $e->getMessage();
    }
  }
}
?>
