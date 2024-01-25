<?php
include("ligaBD.php");

// Verificar se o ID foi passado na URL
$adminId = isset($_GET['id']) ? $_GET['id'] : null;

if ($adminId === null) {
    // Lidar com o caso em que o ID não está presente
    // Por exemplo, redirecionar para uma página de erro
    header("Location: error_page.php");
    exit;
}

// Excluir o admin da base de dados
$sql = "DELETE FROM tb_admins WHERE cod_admin = $adminId";
$conn->query($sql);

// Redirecionar de volta à página de gestão de admins
header("Location: manage_user.php");
exit;

$conn->close();
?>
