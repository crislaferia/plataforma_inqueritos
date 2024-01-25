<?php
include("ligaBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $adminId = $_POST['cod_admin'];
    $newNome = $_POST['nome'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Verificar se a nova senha precisa ser hash
    if (!empty($newPassword)) {
        // Se a nova senha não estiver vazia, hash ela
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Atualizar os dados do admin na base de dados com a nova senha hash
        $sql = "UPDATE tb_admins SET nome = '$newNome', email = '$newEmail', password = '$newPasswordHash' WHERE cod_admin = $adminId";
    } else {
        // Se a nova senha estiver vazia, não hash ela
        $sql = "UPDATE tb_admins SET nome = '$newNome', email = '$newEmail' WHERE cod_admin = $adminId";
    }

    $conn->query($sql);

    // Redirecionar de volta à página de gestão de admins
    header("Location: manage_user.php");
    exit;
} else {
    // Redirecionar em caso de acesso direto ao script
    header("Location: error_page.php");
    exit;
}
?>
