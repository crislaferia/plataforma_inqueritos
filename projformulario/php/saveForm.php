<?php
require 'vendor/autoload.php';

// Configurações do MongoDB
$mongoConfig = [
    'host' => 'localhost',
    'port' => '27017',
    'database' => 'plataformaInqueritos',
];

// Conecta ao MongoDB
$mongoClient = new MongoDB\Client("mongodb://{$mongoConfig['host']}:{$mongoConfig['port']}");
$database = $mongoClient->selectDatabase($mongoConfig['database']);
$collection = $database->selectCollection('questionarios');

// Verifica se a solicitação é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o corpo da solicitação como JSON
    $jsonInput = file_get_contents('php://input');
    
    // Decodifica o JSON
    $questionario = json_decode($jsonInput, true);
    
    // Insere o questionário na coleção 'questionarios'
    $result = $collection->insertOne($questionario);
    
    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'questionarioId' => (string)$result->getInsertedId()]);
} else {
    // Se a solicitação não for um POST, retorna um erro
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Método não permitido'], JSON_PRETTY_PRINT);
}
?>
