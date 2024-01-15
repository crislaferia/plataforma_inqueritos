<?php

include 'PHPMailer.php';
include 'Exception.php';
include 'SMTP.php';
include 'testeenviolink.php';
include 'gerallink.js';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Função para enviar e-mails
function enviarEmails($listaEmails) {
    // Criar uma instância do PHPMailer
    $mail = new PHPMailer (true);

    // Configurar as informações do servidor de e-mail
    $mail->isSMTP();
    $mail->Host = 'mail.cencal.pt';
    $mail->SMTPAuth = true;
    $mail->Username = 'platinq@cencal.pt';
    $mail->Password = 'C6aJEFdI(=1k';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configurar o remetente
    $mail->setFrom('platinq@cencal.pt', 'Plataforma de Inquéritos');

    // Loop para enviar e-mails para cada endereço
    $emails = explode(',', $listaEmails);
    foreach ($emails as $email) {
        $mail->addAddress(trim($email));

        // Configuração do corpo do e-mail, assunto, etc.
        $mail->Subject = 'Link para preenchimento inquerito';
        $mail->Body = "Bem vindo ao Cencal, clique no link abaixo para aceder o formulário:";
        //Aqui vai o link que vem do gerallink.js chamado link completo

        // Enviar o e-mail
        if ($mail->send()) {
            echo 'E-mail enviado com sucesso para ' . $email . '<br>';
        } else {
            echo 'Erro ao enviar o e-mail para ' . $email . ': ' . $mail->ErrorInfo . '<br>';
        }

        // Limpar os destinatários para o próximo e-mail
        $mail->clearAddresses();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailInputado = $_POST['email'];

    // Exemplo de chamada da função com o email inputado pelo usuário
    enviarEmails($emailInputado);
}

?>
