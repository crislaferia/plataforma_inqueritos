
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
            
            //$idFromURL = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_DEFAULT) : null;
            $idFromURL= '65b7acab87589c1e5c0f6436';
            // Verifica se o ID foi recebido corretamente
            if ($idFromURL !== null) {
                // Use o valor de $idFromURL conforme necessário
                // echo "ID recebido da URL: " . $idFromURL;
            } else {
                echo "ID não foi recebido corretamente da URL.";
            }
            
            

            // echo "antes do Valor de id: " . $idFromURL;
            if ($idFromURL!== null) {
                
                $questionarioId = $idFromURL;

                // echo "Valor de 'id' recebido com sucesso: " . $questionarioId;
            } else {
                echo "Erro: Valor de 'id' não está definido na requisição POST.";
            }
if ($questionarioId) {
    // Converter o ID para o formato adequado (ObjectID)
    $questionarioId = new MongoDB\BSON\ObjectID($questionarioId);

// Consultar o MongoDB para obter o questionário específico com respostas
$resposta = $collection->findOne(['_id' => $questionarioId]);

// Adicione esta linha para imprimir a resposta (para fins de depuração)
// var_dump($resposta);

// Verificar se a resposta foi encontrada
if ($resposta) {
    echo '<div class="descricao">';
    echo '<p>' . ($resposta->descricao ?? '') . '</p>';
    echo '</div>';

   // Verificar se o campo 'responses' existe e é um array
if (property_exists($resposta, 'responses') && is_array($resposta->responses->getArrayCopy())) {
    // Exibir perguntas e respostas associadas
    foreach ($resposta->responses->getArrayCopy() as $pergunta) {
        echo '<div class="pergunta">';
        echo '<p>' . ($pergunta->categoria ?? '') . ': ' . ($pergunta->pergunta ?? '') . '</p>';

        // Verificar e exibir a resposta
        echo 'Resposta: ' . ($pergunta->resposta ?? 'Não disponível');

        echo '</div>';
    }
} else {
    echo "O campo 'responses' não está definido ou não é um array.";
}
}
}
            ?>
            
        </form>
    </div>
