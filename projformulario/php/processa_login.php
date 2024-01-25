<?php
session_unset();
session_destroy();
session_start();

$email = $_POST['username'];
$password = $_POST['password'];

include 'ligaBD.php';

$query = "SELECT * FROM tb_admins WHERE email='".$email."'";
$resultado = mysqli_query($liga, $query);

if (mysqli_num_rows($resultado) <= 0) {
    echo "<script>alert('Dados de login inválidos');</script>";
    echo "<script>window.location.href='loginadmin.php';</script>";
} else {
    $row = mysqli_fetch_assoc($resultado);

    // Verifique se a senha no banco de dados é um hash usando password_verify
    if (password_verify($password, $row['password'])) {
        // Senha válida (hash)
        $nome = strtoupper($row['nome']);
        $_SESSION['username'] = $nome;

        // Adicione mensagens de depuração para verificar o valor de $row['admin']
        echo "Valor de admin no banco de dados: " . $row['admin'] . "<br>";

        // Logo após autenticar o utilizador e definir $_SESSION['admin']
        if ($row['admin'] == 1) {
            $_SESSION['admin'] = true;
            echo "Utilizador é um administrador<br>";
        } else {
            echo "Utilizador NÃO é um administrador<br>";
        }

        $msg = "Bem-vindo $nome";
        echo "<script>alert('".$msg."');</script>";
        echo "<script>window.location.href='../index.php';</script>";
    } else {
        // Se password_verify falhar, pode ser uma senha antiga sem hash
        // Adicione lógica para verificar a senha sem hash (substitua pela sua lógica)
        if ($password == $row['password']) {
            // Senha válida (sem hash)
            $nome = strtoupper($row['nome']);
            $_SESSION['username'] = $nome;

            // Adicione mensagens de depuração para verificar o valor de $row['admin']
            echo "Valor de admin no banco de dados: " . $row['admin'] . "<br>";

            // Logo após autenticar o utilizador e definir $_SESSION['admin']
            if ($row['admin'] == 1) {
                $_SESSION['admin'] = true;
                echo "Utilizador é um administrador<br>";
            } else {
                echo "Utilizador NÃO é um administrador<br>";
            }

            $msg = "Bem-vindo $nome";
            echo "<script>alert('".$msg."');</script>";
            echo "<script>window.location.href='../index.php';</script>";
        } else {
            // Senha inválida
            echo "<script>alert('Dados de login inválidos');</script>";
            echo "<script>window.location.href='loginadmin.php';</script>";
        }
    }
}

mysqli_close($liga);
?>
