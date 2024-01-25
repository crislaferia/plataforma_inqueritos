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
    /* echo 'Token recebido: ' . $token . '<br>';
    echo 'Data de Expiração: ' . $dataExpiracao . '<br>';
    echo 'Data Atual: ' . date('Y-m-d H:i:s') . '<br>';
    echo 'nova Senha: ' . $novaSenha . '<br>'; */

    // ...

    if ($adminId) {
        // Token válido, verifica se a data de expiração ainda é válida
        if (!empty($dataExpiracao)) {
            $dataAtual = new DateTime();
            $dataExpiracaoObj = new DateTime($dataExpiracao);
    
            if ($dataExpiracaoObj > $dataAtual) {
                // ... (seu código anterior)
    
                echo 'Senha redefinida com sucesso. Redirecionando para a página de login em 3 segundos...';
    
                // Redirecionamento após 3 segundos usando JavaScript
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "loginadmin.php";
                        }, 3000);
                      </script>';
                
            } else {
                echo 'Token expirado. Redirecionando para a página de login em 3 segundos...';
    
                // Redirecionamento após 3 segundos usando JavaScript
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "loginadmin.php";
                        }, 3000);
                      </script>';
            }
        } else {
            echo 'A data de expiração não está definida para este token. Redirecionando para a página de login em 3 segundos...';
    
            // Redirecionamento após 3 segundos usando JavaScript
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "loginadmin.php";
                    }, 3000);
                  </script>';
        }
    } else {
        echo 'Token inválido. Redirecionando para a página de login em 3 segundos...';
    
        // Redirecionamento após 3 segundos usando JavaScript
        echo '<script>
                setTimeout(function() {
                    window.location.href = "loginadmin.php";
                }, 3000);
              </script>';
    }

// ...


    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo 'Parâmetros inválidos.';
}
?>
