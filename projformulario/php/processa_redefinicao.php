<?php
session_start();

// Verifica se há um token e uma nova senha
if (isset($_REQUEST['token']) && isset($_REQUEST['nova_senha'])) {
    $token = $_REQUEST['token'];
    $novaSenha = $_REQUEST['nova_senha'];

    // Conecta-se ao seu banco de dados
    include("ligaBD.php");

    // Verifica se o token é válido
    $stmt = $conn->prepare("SELECT cod_admin, data_expiracao FROM tb_admins WHERE token = ? AND data_expiracao > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($adminId, $dataExpiracao);
    $stmt->fetch();
    
    // Feche os resultados pendentes
    $stmt->close();

    // Adicione essas mensagens de depuração
    echo 'Token recebido: ' . $token . '<br>';
    echo 'Data de Expiração: ' . $dataExpiracao . '<br>';
    echo 'Data Atual: ' . date('Y-m-d H:i:s') . '<br>';
    echo 'nova Senha: ' . $novaSenha . '<br>';

    // ...

    if ($adminId) {
        // Token válido, verifica se a data de expiração ainda é válida
        if (!empty($dataExpiracao)) {
            $dataAtual = new DateTime();
            $dataExpiracaoObj = new DateTime($dataExpiracao);
        
            if ($dataExpiracaoObj > $dataAtual) {
                // Token é válido, aplica o hash à nova senha
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        
                // Atualiza a senha e remove o token (se necessário)
                $stmt = $conn->prepare("UPDATE tb_admins SET password = ?, token = NULL, data_expiracao = NULL WHERE cod_admin = ?");
                $stmt->bind_param("si", $novaSenhaHash, $adminId);
                $stmt->execute();
        
                echo 'Senha redefinida com sucesso.';
        
                // Verifica se a senha foi atualizada com sucesso
                $verificaSenhaStmt = $conn->prepare("SELECT password FROM tb_admins WHERE cod_admin = ?");
                $verificaSenhaStmt->bind_param("i", $adminId);
                $verificaSenhaStmt->execute();
                $verificaSenhaStmt->bind_result($senhaArmazenada);
                $verificaSenhaStmt->fetch();
        
                if (password_verify($novaSenha, $senhaArmazenada)) {
                    echo 'Senha atualizada com sucesso.';
                } else {
                    echo 'Erro ao verificar a senha.';
                }
        
            } else {
                echo 'Token expirado.';
            }
        } else {
            echo 'A data de expiração não está definida para este token.';
        }
    } else {
        echo 'Token inválido.';
    }

// ...


    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo 'Parâmetros inválidos.';
}
?>
