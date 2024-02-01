
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
            // Imprimir para fins de depuração
            //echo "Valor de 'id' recebido: " . $idFromURL;
            //$idFromURL= '65badad9bd28c4c00d0e94ee';
            // Verifica se o ID foi recebido corretamente
if ($idFromURL !== null) {
    // Use o valor de $idFromURL conforme necessário
    $questionarioId = $idFromURL;
    //var_dump($questionarioId); // Adicione esta linha para imprimir o valor de $questionarioId
    // echo "ID recebido da URL: " . $idFromURL;
} else {
    echo "ID não foi recebido corretamente da URL.";
}

// ...

if ($questionarioId) {
    // Converter o ID para o formato adequado (ObjectID)
    $questionarioId = new MongoDB\BSON\ObjectID($questionarioId);

    // Consultar o MongoDB para obter o questionário específico com respostas
    $resposta = $collection->findOne(['_id' => $questionarioId]);

    if ($resposta) {
        // Exibir o documento encontrado
        //var_dump($resposta);

        echo '<div class="title">';
        echo '<p>' . ($resposta->title ?? '') . '</p>';
        echo '</div>';

        // Verificar se 'responses' é uma instância de MongoDB\Model\BSONDocument
        if ($resposta->responses instanceof MongoDB\Model\BSONDocument) {
            // Exibir perguntas e respostas associadas
            foreach ($resposta->responses as $pergunta => $resposta) {
                echo '<div class="pergunta">';
                echo '<p>Pergunta: ' . $pergunta . '</p>';
                echo '<p>Resposta: ' . $resposta . '</p>';
                echo '</div>';
            }
        } else {
            echo "O campo 'responses' não está definido ou não é um objeto BSONDocument.";
        }
    } else {
        echo "Não foi possível encontrar a resposta para o ID especificado.";
    }
}
            ?>
            
        </form>
    </div>
