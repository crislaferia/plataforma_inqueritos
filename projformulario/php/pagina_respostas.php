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
        <form class="botao-resposta" action="obrigado.php" method="post">
            <?php
            // Connect to MongoDB
            require 'vendor/autoload.php';
            $client = new MongoDB\Client('mongodb://localhost');


            // Select the database and collection
            $databaseName = 'plataformaiInqueritos';
            $collectionName = 'questionarios';
            $collection = $client->$databaseName->$collectionName;

            // Display the questionnaire
            $perguntas = $collection->findOne();
            foreach ($perguntas->perguntas as $pergunta) {
                echo '<div class="pergunta">';
                echo '<p>' . $pergunta->categoria . ': ' . $pergunta->pergunta . '</p>';

                // Add options for response (assuming they are selection options)
                foreach ($pergunta->opcoes as $opcao) {
                    echo '<label class="opcao">';
                    echo '<input type="radio" name="respostas[' . $pergunta->categoria . '][' . $pergunta->pergunta . ']" value="' . $opcao . '">' . $opcao;
                    echo '</label>';
                }

                echo '</div>';
            }
            ?>
            <input type="submit" value="Enviar respostas">
        </form>
    </div>
</body>

</html>

