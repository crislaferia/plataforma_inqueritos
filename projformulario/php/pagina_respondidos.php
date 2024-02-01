
<body>


    <div id="container">
        <div class="mensagem-resposta">
            <p>FORMULARIO RESPONDIDO</p>
        
        </div>
    

        
            <?php
            // Connect to MongoDB
            require 'vendor/autoload.php';
            $client = new MongoDB\Client('mongodb://localhost');


            // Select the database and collection
            $databaseName = 'plataformaInqueritos';
            $collectionName = 'respostas';
            $collection = $client->$databaseName->$collectionName;
            // echo "success";
            //$questionarioId = isset($_POST['id']) ? $_POST['id'] : null;
            //$questionarioId ='65af998df4ae3f02297af012';

            
            // Obtém o valor do parâmetro 'id' da URL
$idFromURL = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_DEFAULT) : null;

// Verifica se o ID foi recebido corretamente
if ($idFromURL !== null) {
    // Use o valor de $idFromURL conforme necessário
    $questionarioId = $idFromURL;

    // Verifica se $questionarioId é uma string válida antes de continuar
    if (!empty($questionarioId)) {
        // Converter o ID para o formato adequado (ObjectID)
        $questionarioId = new MongoDB\BSON\ObjectID($questionarioId);

        // Consultar o MongoDB para obter o questionário específico com respostas
        $resposta = $collection->findOne(['_id' => $questionarioId]);

        // Verificar se $resposta é definido e não é null
if ($resposta !== null) {
    $responses = $resposta->responses;

    // Verificar se 'responses' é uma instância de MongoDB\Model\BSONDocument
    if ($responses instanceof MongoDB\Model\BSONDocument) {
        foreach ($responses as $pergunta => $response) {
            echo '<div class="pergunta">';
            
            // Extrair o número da pergunta da chave do array
            $perguntaNumber = rtrim($pergunta, ':');

            // Verificar se 'question' está definido ou não vazio; se não, use 'question', senão use 'Observações'
            $perguntaText = isset($response['question']) && !empty($response['question']) ? $response['question'] : 'Observações';

            // Assumindo que 'answer' é um campo no seu BSONDocument
            echo '<p>Pergunta ' . $perguntaNumber . ': ' . $perguntaText . '</p>';
            echo '<p>Resposta: ' . $response['answer'] . '</p>';
            
            echo '</div>';
        }
    } else {
        echo "O campo 'responses' não está definido ou não é um objeto BSONDocument.";
    }
} else {
    echo "Não foi possível encontrar a resposta para o ID especificado.";
}
    } else {
        echo "ID não foi recebido corretamente da URL.";
    }
} else {
    echo "ID não foi recebido corretamente da URL.";
}
            ?>
            
        </form>
    </div>
