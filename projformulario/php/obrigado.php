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

    foreach ($_POST['respostas'] as $key => $value) {
        // Separar a chave em categoria e pergunta
        list($categoria, $pergunta) = explode('_', $key);

        // Verificar se a pergunta é de seleção ou texto
        if (strpos($pergunta, 'question_') === 0) {
            // Se for uma pergunta de seleção (radio-group, evaluation-group, etc.)
            $allResponses[] = [
                'categoria' => $categoria,
                'pergunta' => $pergunta,
                'resposta' => $value,
            ];
        } else {
            // Se for uma pergunta de texto (simple-question-group, observations-group, etc.)
            $allResponses[] = [
                'categoria' => $categoria,
                'pergunta' => $pergunta,
                'resposta_texto' => $value,
            ];
        }
    }

    // Tratar inserção no MongoDB com manipulação de erros
    try {
        // Verificar se $allResponses é um array ou objeto antes de usar o foreach
        if (is_array($allResponses) || is_object($allResponses)) {
            // Iterar sobre cada resposta e inserir no MongoDB
            foreach ($allResponses as $response) {
                $collectionResponses->insertOne(['response' => $response]);
            }

            echo "Respostas salvas com sucesso!";
        } else {
            echo "Erro: As respostas não estão no formato esperado.";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    } catch (Exception $e) {
        // Exibir mensagem de erro
        echo "Erro ao salvar as respostas no MongoDB: " . $e->getMessage();
    }

    // Exibir mensagem de sucesso
    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="Pagina apos responder a inqueritos.">
            <title>Obrigado</title>
            <link rel="icon" type="image/x-icon" href="img/logocencalfav.ico">
            <link rel="stylesheet" href="../css/style.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        </head>
        <body>
            <div class="div">
                <div class="div-2">
                    <img loading="lazy" srcset="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962" class="img" />
                    <section class="contentend">
                        <div class="section">
                            <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/f284db328070a13755c0bec0a003968fb88ed31bc5064ca306a3bab76fb40bb8?apiKey=f707913968e64dada259d321cef35518&" class="section-img" />
                            <header class="title">Obrigado por preencher o questionário!</header>
                        </div>
                    </section>
                </div>
            </div>
        </body>
        </html>';
    exit();
}
?>
