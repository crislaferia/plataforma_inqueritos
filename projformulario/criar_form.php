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
    <title>Texte Index</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <style>
       
    </style>
</head>
 
<body style="overflow: hidden;">

    <header>
    <?php include ('php/cabecalho.php'); ?>
    </header>

    <div style="display: flex;">
        <nav class="nav">

        <?php include ('php/menuLateral.php'); ?>
        </nav>

        <section class="sectionhome">
        <?php include ('php/criar.php'); ?>
        </section>
    </div>

    <footer>
        <?php include ('php/rodape.php'); ?>
    </footer>
</body>

</html>
