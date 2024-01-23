<?php

$servername ="localhost";
$user ="root";
$pass = "";
$bd="projeto_final_logins";

$liga = mysqli_connect($servername, $user, $pass, $bd);

if(!$liga) {
    die("Erro ao tentar estabelecer ligação com a base de dados".mysqli_connect_error());
}

?>