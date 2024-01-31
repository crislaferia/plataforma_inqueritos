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

    // Adicionar as respostas diretamente ao array 'responses'
    foreach ($_POST['respostas'] as $key => $value) {
        $allResponses['responses'][$key] = $value;
    }

    // Tratar inserção no MongoDB com manipulação de erros
    try {
        // Verificar se $allResponses é um array ou objeto antes de usar o foreach
        if (is_array($allResponses) || is_object($allResponses)) {
            // Inserir todas as respostas no MongoDB como um único documento
            $collectionResponses->insertOne($allResponses);

            // Redirecionar para uma página de sucesso após salvar no MongoDB
            header("Location: sucesso.php");
            exit();
        } else {
            echo "Erro: As respostas não estão no formato esperado.";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    } catch (Exception $e) {
        // Exibir mensagem de erro
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    }
}
?>
