<?php
session_start();

include 'PHPMailer.php';
include 'Exception.php';
include 'SMTP.php';
include 'phpMailerConfiguration.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function gerarLinkAleatorio($tamanho) {
  $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  $link = '';
  for ($i = 0; $i < $tamanho; $i++) {
    $indice = mt_rand(0, strlen($caracteres) - 1);
    $link .= $caracteres[$indice];
  }
  return $link;
}

function obterLinkCompleto() {
  $linkAleatorio = gerarLinkAleatorio(8);
  $mais = "?=";
  return "http://localhost/plataforma_inqueritos/projformulario/php/pagina_respostas.php" . $mais . $linkAleatorio;
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

$linkCompleto = obterLinkCompleto();
$_SESSION['link'] = $linkCompleto;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $emailInputado = isset($_POST['emails']) ? $_POST['emails'] : '';
  $linkCompleto = isset($_SESSION['link']) ? $_SESSION['link'] : '';
  enviarEmails($emailInputado, $linkCompleto, $config);
}
?>
