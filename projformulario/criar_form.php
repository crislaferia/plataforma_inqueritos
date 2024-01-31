<?php
session_start();

// Verificar se a sessão não está ativa
if (!isset($_SESSION['username'])) {
    // Redirecionar para a página de login
    header("Location: php/loginadmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar</title>
    <link rel="stylesheet" href="css/criarformulario.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/menulateral.css" />

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <style>
       
    </style>
</head>
 
<body style="overflow: hidden;">

    <header style="font-size: 17px;">
    <?php include ('php/cabecalho.php'); ?>
    </header>

    <div style="display: flex;">
        <nav class="nav">

        <?php include ('php/menuLateral.php'); ?>
        </nav>

        <section class="sectionhome" style="overflow: hidden;">
        <?php include ('php/criarformulario.php'); ?>
        </section>
    </div>

    <footer style="overflow: hidden; font-family: Arial, sans-serif; font-size: 16px;">
        <?php include ('php/rodape.php'); ?>
    </footer>
</body>

</html>
