<?php
// remover_opcao.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require '/laragon/www/projformulario/php/vendor/autoload.php';

use MongoDB\Client;

echo "Início do script...";

$client = new Client('mongodb://localhost');
echo "Conexão com o MongoDB estabelecida...";
$databaseName = 'plataformaiInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Receber o valor a ser removido da solicitação POST
$valorRemover = $_POST['valor'];

echo "Valor a ser removido: $valorRemover";

try {
    // Remover o documento com o valor correspondente
    $resultado = $collection->deleteOne(['valor' => $valorRemover]);

    // Enviar uma resposta para indicar o sucesso ou falha da operação
    if ($resultado->getDeletedCount() > 0) {
        echo "success";
    } else {
        echo "error: Documento não encontrado";
    }
} catch (Exception $e) {
    echo "error: " . $e->getMessage();
}
?>
