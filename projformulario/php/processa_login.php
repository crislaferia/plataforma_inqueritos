<?php
session_start();

$email = $_POST['username'];
$password = $_POST['password'];

include 'ligaBD.php';

$query = "SELECT * FROM tb_admins WHERE email='".$email."' and password='".$password."'";
$resultado = mysqli_query($liga, $query);

if (mysqli_num_rows($resultado) <= 0) {
    echo "<script>alert('Dados de login inválidos');</script>";
    echo "<script>window.location.href='loginadmin.php';</script>";
} else {
    $row = mysqli_fetch_assoc($resultado);
    $nome = $row['nome'];
    $_SESSION['username'] = $nome; // Armazenando o nome do usuário na sessão
    $msg = "Bem-vindo $nome";
    echo "<script>alert('".$msg."');</script>";
    echo "<script>window.location.href='../index.php';</script>";
}

mysqli_close($liga);
?>
