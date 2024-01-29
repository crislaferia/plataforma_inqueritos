<?php
require_once('vendor/autoload.php');
require_once('phplot/phplot.php');

// Suprimir avisos de depreciação
error_reporting(E_ERROR | E_PARSE);

// Conectar ao MongoDB
$client = new MongoDB\Client('mongodb://localhost');

// Selecionar o banco de dados e a coleção
$databaseName = 'plataformaInqueritos';
$collectionName = 'respostas';
$collection = $client->$databaseName->$collectionName;

// Buscar as respostas
$respostas = $collection->find();

// Inicializar arrays para os dados do gráfico
$labels = [];
$data = [];

// Processar as respostas e organizar dados para o gráfico
foreach ($respostas as $resposta) {
    foreach ($resposta->responses as $response) {
        $pergunta = $response->pergunta;
        $resposta = $response->resposta;

        // Adicione a pergunta como label se ainda não existir
        if (!in_array($pergunta, $labels)) {
            $labels[] = $pergunta;
        }

        // Adicione a resposta ao array de dados
        if (!isset($data[$pergunta])) {
            $data[$pergunta] = [];
        }
        $data[$pergunta][] = $resposta;
    }
}

// Criar um objeto PHPlot
$plot = new PHPlot(800, 600);

$plot->SetPlotType('bars');

// Adicionar dados ao gráfico
$datasets = [];
foreach ($labels as $label) {
    $datasets[] = [
        $label,
        array_sum($data[$label]) / count($data[$label]) // Média das respostas para cada pergunta
    ];
}

$plot->SetDataValues($datasets);

// Configurar o título e rótulos
$plot->SetTitle('Media das Respostas para Cada Pergunta');
$plot->SetXTitle('Perguntas');
$plot->SetYTitle('Media das Respostas');

// Exibir o gráfico
$plot->DrawGraph();
?>
