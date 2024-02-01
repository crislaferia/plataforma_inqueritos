<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inqueritos a serem respondidos para estatística do CENCAL.">
    <title>Inquerito</title>
    <link rel="icon" type="image/x-icon" href="img/logocencalfav.ico">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: black; /* Adicionado para garantir que o texto seja preto */
        }

        #container {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            overflow-y: auto;
            background-color: white;
        }
        .mensagem-resposta{
            color: black;
        }

        .pergunta {
            margin-bottom: 20px;
        }

        .opcao {
            margin-right: 10px;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <img loading="lazy"
        srcset="https://cencal.pt/versions/v7.1.2.0/public/branding.501886354/logo.png?a=1698141962"
        style="max-width: 100%; height: auto; margin: 20px;">

    <div id="container">
        <div class="mensagem-resposta">
            <p>Com o objetivo de avaliar e analisar a utilidade e o impacto da ação de formação que frequentou no Cencal,
                agradecemos que preencha este inquérito, já que esta avaliação é fundamental para a eventual implementação
                de mudanças e processos de melhorias dos serviços prestados.</p>
            <p>Os dados recolhidos neste inquérito serão confidenciais.</p>
        
        </div>
        
        
        <form class="botao-resposta" action="salvar_resposta.php" method="post">



        
            <?php
            // Connect to MongoDB
            require 'vendor/autoload.php';
            $client = new MongoDB\Client('mongodb://localhost');


            // Select the database and collection
            $databaseName = 'plataformaInqueritos';
            $collectionName = 'questionarios';
            $collection = $client->$databaseName->$collectionName;
            // echo "success";
            //$questionarioId = isset($_POST['id']) ? $_POST['id'] : null;
            //$questionarioId ='65af998df4ae3f02297af012';

            
            // Obtém o valor do parâmetro 'id' da URL
            $idFromURL = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_DEFAULT) : null;
            
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
            
                // Consultar o MongoDB para obter o questionário específico
                $documento = $collection->findOne(['_id' => $questionarioId]);
            
                // Verificar se o questionário foi encontrado
                if ($documento) {
                    // Verificar se os campos esperados estão definidos no documento
                    if (isset($documento->title)) {
                        echo '<div class="titulo">';
                        echo '<h2>' . $documento->title . '</h2>';
                        echo '</div>';
                
                        echo '<input type="hidden" name="title" value="' . $documento->title . '">';
                
                        foreach ($documento as $key => $question) {
                            // Verificar se a chave é uma pergunta
                            if (isset($question->type)) {
                                echo '<div class="pergunta">';
                                echo '<p>' . $question->question . '</p>';
                                echo '<input type="hidden" name="questions[' . $key . ']" value="' . $question->question . '">';
                
                                if ($question->type === "simple-question-group") {
                                    // Adicionar caixa de texto para resposta
                                    echo '<textarea name="respostas[' . $key . ']" rows="4" cols="50" placeholder="Digite sua resposta aqui..."></textarea>';
                                }elseif($question->type === "observations-group"){
                                    echo '<p>Observações</p>';
                                    echo '<textarea name="respostas[' . $key . ']" rows="4" cols="50" placeholder="Se tiver alguma Sugestão/Observação escreva neste campo."></textarea>';
                                } 
                                elseif ($question->type === "radio-group" || $question->type === "evaluation-group") {
                                    // Adicionar opções de resposta (radio-group ou evaluation-group)
                                    foreach ($question->options as $opcao) {
                                        echo '<label class="opcao">';
                                        if ($question->type === "radio-group") {
                                            echo '<input type="radio" name="respostas[' . $key . ']" value="' . $opcao . '">' . $opcao;
                                        } elseif ($question->type === "evaluation-group") {
                                            echo '<input type="radio" name="respostas[' . $key . ']" value="' . $opcao . '">' . $opcao;
                                        }
                                        echo '</label>';
                                    }
                                } else {
                                    echo "Erro: Tipo de pergunta desconhecido.";
                                }
                
                                echo '</div>';
                            }
                        }
                    } else {
                        echo "Erro: O documento não possui o campo 'title'.";
                    }
                } else {
                    echo "Formulário não encontrado.";
                }
            }
            

            
            ?>
            <input type="submit" value="Enviar respostas">
        </form>
    </div>
</body>

</html>