<?php
include("ligaBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $adminId = $_POST['cod_admin'];
    $newNome = $_POST['nome'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Atualizar os dados do admin na base de dados
    $sql = "UPDATE tb_admins SET nome = '$newNome', email = '$newEmail', password = '$newPassword' WHERE cod_admin = $adminId";
    $conn->query($sql);

    // Redirecionar de volta à página de gestão de admins
    header("Location: manage_users.php");
    exit;
} else {
    // Redirecionar em caso de acesso direto ao script
    header("Location: error_page.php");
    exit;
}
?>
