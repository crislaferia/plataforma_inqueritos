<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/vendor/autoload.php';

    // Conectar ao MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Selecionar o banco de dados e a coleção para salvar as respostas
    $databaseName = 'plataformaInqueritos';
    $collectionName = 'respostas';
    $collectionResponses = $client->$databaseName->$collectionName;

    // Processar e salvar respostas
    $allResponses = [];

    // Adicionar o título ao array de respostas, se existir
    if (isset($_POST['title'])) {
        $allResponses['title'] = $_POST['title'];
    }

    // Adicionar as perguntas e respostas diretamente ao array 'responses'
    foreach ($_POST['respostas'] as $key => $value) {
        $questionId = $key; // remova o ':' aqui
        $allResponses['responses'][$questionId]['question'] = $_POST['questions'][$key];
        $allResponses['responses'][$questionId]['answer'] = $value;
    }

    // Tratar inserção no MongoDB com manipulação de erros
    try {
        // Inserir todas as respostas no MongoDB como um único documento
        $collectionResponses->insertOne($allResponses);

        // Redirecionar para uma página de sucesso após salvar no MongoDB
        header("Location: sucesso.php");
        exit();
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    } catch (Exception $e) {
        // Exibir mensagem de erro
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    }
}
?>
