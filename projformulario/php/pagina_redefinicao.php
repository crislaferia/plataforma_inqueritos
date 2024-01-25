<!-- pagina_redefinicao.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>
<body>
    <h2>Redefinição de Senha</h2>

    <?php
    // Verifique se há um token de redefinição de senha na URL
    if (isset($_GET['token'])) {  // Alterado de $_POST para $_GET
        $token = $_GET['token'];
        // Aqui você pode verificar se o token é válido e permitir a redefinição de senha
        echo '<p>Insira a nova senha:</p>';
        echo '<form action="processa_redefinicao.php" method="post">';
        echo '<input type="password" name="nova_senha" required>';
        echo '<input type="hidden" name="token" value="' . $token . '">';
        echo '<input type="submit" value="Redefinir Senha">';
        echo '</form>';
    } else {
        echo '<p>Token inválido. Por favor, siga o link enviado para o seu e-mail.</p>';
    }
    ?>
</body>
</html>
