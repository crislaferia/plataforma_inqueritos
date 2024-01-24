<?php
// remover_opcao.php

error_log("Antes do header");
header('Content-Type: text/plain; charset=utf-8');
error_log("Depois do header");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require '/laragon/www/projformulario/php/vendor/autoload.php';

use MongoDB\Client;

echo "Início do script...";

$client = new Client('mongodb://localhost');
echo "Conexão com o MongoDB estabelecida...";
$databaseName = 'plataformaInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Receber o valor a ser removido da solicitação POST
$valorRemover = filter_var($_POST['valor']);

error_log("Antes da remoção. Valor a ser removido: " . $valorRemover);


try {
    // Remover o documento com o valor correspondente
    $result = $collection->deleteOne(['valor' => $valorRemover]);
error_log("Depois da remoção. Resultado: " . print_r($result, true));

    // Enviar uma resposta para indicar o sucesso ou falha da operação
    if ($result->isAcknowledged()) {
        echo "success";
    } else {
        echo "error";
        error_log("Erro ao remover a opção. MongoDB Delete Result: " . print_r($result, true));
    }
} catch (Exception $e) {
    // Adicione logs para identificar o motivo do erro
    error_log("Erro ao remover a opção: " . $e->getMessage());
    echo "error";
}
?>
