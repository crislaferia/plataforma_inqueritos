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

// Consulta SQL para obter dados do admin pelo ID
$sql = "SELECT * FROM tb_admins WHERE cod_admin = $adminId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    // Exibir um formulário com os dados do admin para edição
    echo "<form method='post' action='update_user.php'>";
    echo "Nome: <input type='text' name='nome' value='{$admin['nome']}'><br>";
    echo "Email: <input type='text' name='email' value='{$admin['email']}'><br>";
    echo "Password: <input type='text' name='password' value='{$admin['password']}'><br>";
    echo "<input type='hidden' name='cod_admin' value='{$admin['cod_admin']}'>";
    echo "<input type='submit' value='Salvar'>";
    echo "</form>";
    
} else {
    // Lidar com o caso em que o admin não foi encontrado
    echo "Admin não encontrado.";
}

$conn->close();
?>
