<!-- create_user.php -->

<?php
include("ligaBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o formulário para criar um novo usuário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Executar uma inserção na base de dados
    $sql = "INSERT INTO tb_admins (nome, email, password) VALUES ('$nome', '$email', '$password')";
    $conn->query($sql);

    // Redirecionar de volta à página de gestão de admins
    header("Location: manage_user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Utilizador</title>
</head>
<body>

<h2>Adicionar Novo Utilizador</h2>

<form method="post" action="">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Adicionar Utilizador">
</form>

</body>
</html>
