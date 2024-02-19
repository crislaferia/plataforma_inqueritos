<?php
// Conecte-se ao banco de dados MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Buscar os dados do formulário no MongoDB
$formData = $collection->findOne([]);

// Retornar os dados do formulário como JSON
echo json_encode($formData);
?>
