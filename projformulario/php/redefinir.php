
<!-- redefinir.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
</head>
<body>

    <form action="redefinir.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Enviar E-mail de Redefinição</button>
    </form>

</body>
</html>
<!-- redefinir.php -->
<?php
// Conecta-se ao seu banco de dados
include("ligaBD.php");
// Envia o e-mail com o link de redefinição de senha usando o PHPMailer
require 'PHPMailer.php';
require 'Exception.php';
require 'SMTP.php';
require 'phpMailerConfiguration.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo de e-mail foi enviado no formulário
    if (isset($_POST['email'])) {
        $emailInputado = $_POST['email'];

        // Gera um link aleatório para a redefinição de senha
        function gerarLinkAleatorio($tamanho) {
            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $link = '';
            for ($i = 0; $i < $tamanho; $i++) {
                $indice = mt_rand(0, strlen($caracteres) - 1);
                $link .= $caracteres[$indice];
            }
            return $link;
        }

        $token = gerarLinkAleatorio(8);
        $dataExpiracao = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expira em 1 hora

        // Insere o token e a data de expiração na tabela
        $stmt = $conn->prepare("UPDATE tb_admins SET token = ?, data_expiracao = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $dataExpiracao, $emailInputado);
        $stmt->execute();

        $linkRedefinicao = "http://localhost/projformulario/php/pagina_redefinicao.php?token=" . $token;

        // Envia o e-mail com o link de redefinição de senha usando o PHPMailer
        

        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = $config['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp_username'];
            $mail->Password = $config['smtp_password'];
            $mail->SMTPSecure = $config['smtp_secure'];
            $mail->Port = $config['smtp_port'];

            // Remetente e destinatário do e-mail
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($emailInputado);

            // Assunto e corpo do e-mail
            $mail->Subject = 'Redefinição de Senha';
            $mail->isHTML(true);
            $mail->Body = 'Clique no seguinte <a href="' . $linkRedefinicao . '">link</a> para redefinir sua senha.';

            // Envia o e-mail
            $mail->send();

            echo 'Um e-mail com as instruções de redefinição de senha foi enviado para o seu endereço de e-mail.';
        } catch (Exception $e) {
            echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Por favor, insira um endereço de e-mail válido.';
    }
}
?>
