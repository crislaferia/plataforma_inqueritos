
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Projeto</title>
  <link rel="stylesheet" href="../css/criarformulario.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="kanban">
    <div class="column first-column">
      <div class="item" draggable="true">Botões de escolha</div>
      <div class="item" draggable="true">Pergunta simples</div>
      <div class="item" draggable="true">Pontuacao</div>
      <div class="item" draggable="true">Observações</div>
    </div>
    <div class="column second-column">
      <div class="form-title-section">
        <label class="label" for="form-title">Título do Formulário: </label>
        <input type="text" id="form-title" placeholder="Insira o título do formulário">
      </div>
      <div id="contentor">
        <div class="radio-group-container"></div>
        <button id="saveFormButton">Guardar formulário</button>
        <div class="popup" id="popup">
          <span class="close-popup" id="close-popup">&times;</span>
          <div class="popup-content">
            <p class="popup-message">Formulário guardado com sucesso!</p>
          </div>
        </div>
      </div>
    </div>   
  </div>

  <script>
    $(document).ready(function() {
        // Faz uma solicitação AJAX para obter os detalhes do formulário
        $.ajax({
            url: 'editar_formulario.php?idmongo=65bbb712bd28c4c00d0e9512', // Substitua pelo ID correto
            type: 'GET',
            dataType: 'json',
            success: function(formData) {
              const formData = {"_id":{"$oid":"65bbb712bd28c4c00d0e9512"},"title":"Formulario Mod Teste","1:":{"type":"radio-group","question":"O que achaste deste projecto","options":["Interessante","Podia ser outra coidsa","maldireccionado","outro"],"reply":[null]},"2:":{"type":"simple-question-group","question":"Voltarias a fazer este projecto","reply":[null]},"3:":{"type":"evaluation-group","question":"O que achaste deste modulo","options":["1","2","3","4","5"],"reply":[null]},"4:":{"type":"observations-group","question":"","reply":[null]}};
                exibirFormularioExistente(formData);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Erro na solicitação AJAX: ' + textStatus + ' - ' + errorThrown);
            }
        });

        // Função para exibir o formulário existente com base nos dados recuperados
        function exibirFormularioExistente(formData) {
            $('#form-title').val(formData.title);
            for (const key in formData) {
                if (key !== '_id' && key !== 'title') {
                    const group = formData[key];
                    if (group.type === 'radio-group') {
                        // Crie elementos HTML para um grupo de botões de rádio
                        const container = $('.radio-group-container');
                        const div = $('<div>');
                        const question = $('<p>').text(group.question);
                        div.append(question);
                        group.options.forEach(option => {
                            const input = $('<input>').attr({
                                type: 'radio',
                                name: key,
                                value: option
                            });
                            const label = $('<label>').text(option);
                            div.append(input).append(label).append($('<br>'));
                        });
                        container.append(div);
                    } else if (group.type === 'simple-question-group') {
                        // Crie elementos HTML para uma pergunta simples
                        const container = $('.radio-group-container');
                        const div = $('<div>');
                        const question = $('<p>').text(group.question);
                        const input = $('<input>').attr('type', 'text');
                        div.append(question).append(input);
                        container.append(div);
                    } else if (group.type === 'evaluation-group') {
                        // Crie elementos HTML para um grupo de avaliação
                        const container = $('.radio-group-container');
                        const div = $('<div>');
                        const question = $('<p>').text(group.question);
                        div.append(question);
                        group.options.forEach(option => {
                            const input = $('<input>').attr({
                                type: 'radio',
                                name: key,
                                value: option
                            });
                            const label = $('<label>').text(option);
                            div.append(input).append(label).append($('<br>'));
                        });
                        container.append(div);
                    } else if (group.type === 'observations-group') {
                        // Crie elementos HTML para um grupo de observações
                        const container = $('.radio-group-container');
                        const div = $('<div>');
                        const question = $('<p>').text(group.question);
                        const textarea = $('<textarea>').attr({
                            rows: 4,
                            cols: 50
                        });
                        div.append(question).append(textarea);
                        container.append(div);
                    }
                }
            }
        }
    });
  </script>
</body>
</html>

<?php
// Conecte-se ao banco de dados MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Verifique se o ID do formulário foi fornecido
if (isset($_GET['idmongo'])) {
    $formId = $_GET['idmongo'];
    
    try {
        // Busque os detalhes do formulário pelo ID no MongoDB
        $formDetails = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($formId)]);
        // Se os detalhes do formulário foram encontrados, retorne-os como JSON
        if ($formDetails) {
            echo json_encode($formDetails);
        } else {
            // Se não houver detalhes do formulário, retorne uma mensagem de erro
            echo json_encode(['error' => 'Formulário não encontrado']);
        }
        exit; // Saia do script PHP após retornar os detalhes do formulário
    } catch (Exception $e) {
        echo json_encode(['error' => 'Erro ao buscar o formulário: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID do formulário não fornecido']);
    exit; // Saia do script PHP se o ID do formulário não foi fornecido
}?>