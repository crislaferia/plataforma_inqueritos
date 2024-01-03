<?php

$servername ="localhost";
$user ="root";
$pass = "";
$bd="login";

$liga = mysqli_connect($servername, $user, $pass, $bd);

if(!$liga) {
    die("Erro ao tentar estabelecer ligação com a base de dados".mysqli_connect_error());
}

?>