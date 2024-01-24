<?php
session_start();

include 'PHPMailer.php';
include 'Exception.php';
include 'SMTP.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Inicializar a variável $linkCompleto dentro do bloco POST
function gerarLinkAleatorio($tamanho) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $link = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $indice = mt_rand(0, strlen($caracteres) - 1);
        $link .= $caracteres[$indice];
    }
    return $link;
}

// Usando a função para gerar um link aleatório de 8 caracteres
$linkAleatorio = gerarLinkAleatorio(8);
$mais = "?=";
$linkCompleto = "http://localhost/plataforma_inqueritos/projformulario/php/pagina_respostas.php" . $mais . $linkAleatorio;

// Armazenar $linkCompleto na sessão
$_SESSION['link'] = $linkCompleto;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailInputado = isset($_POST['emails']) ? $_POST['emails'] : '';
    $linkCompleto = isset($_SESSION['link']) ? $_SESSION['link'] : '';

    //echo 'Link Recebido: ' . htmlspecialchars($linkCompleto);
    enviarEmails($emailInputado, $linkCompleto);
    
}
 
function enviarEmails($listaEmails, $linkCompleto) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'mail.cencal.pt';
    $mail->SMTPAuth = true;
    $mail->Username = 'platinq@cencal.pt';
    $mail->Password = 'C6aJEFdI(=1k';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('platinq@cencal.pt', 'Plataforma de Inquéritos');

    $emailes = explode(',', $listaEmails);
    foreach ($emailes as $emails) {
        try {
            $mail->addAddress(trim($emails));
    
            $mail->Subject = 'Link para preenchimento inquerito';
            $mail->isHTML(true);
            // Remova htmlspecialchars do $linkCompleto
            $mail->Body = "Bem-vindo ao Cencal, clique no link abaixo para aceder o formulário: <a href='$linkCompleto'>$linkCompleto</a>";
            //echo 'Conteúdo do Link: ' . $linkCompleto;
            if ($mail->send()) {
                echo 'E-mail enviado com sucesso para ' . $emails;
            } else {
                throw new Exception('Erro ao enviar o e-mail: ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        } finally {
            // Limpar os destinatários para o próximo e-mail
            $mail->clearAddresses();
        }
    }
}