<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Projeto</title>

  <link rel="stylesheet" href="css/criarformulario.css" />
</head>
<body>
  <div class="kanban">
    <div class="column">
      <div class="item" draggable="true">Botões de escolha</div>
      <div class="item" draggable="true">Pergunta simples</div>
      <div class="item" draggable="true">Pontuacao</div>
      <div class="item" draggable="true">Observações</div>
    </div>
    <div class="column second-column">
      <div class="form-title-section">
        <label class="label" for="form-title" style="color: #F5F8FA;">Título do Formulário: </label>
        <input type="text" id="form-title" placeholder="Insira o título do formulário">
      </div>
      <div class="radio-group-container"></div>
      <button>Guardar formulário</button>
    </div>
    
  </div>

  <script src="js/criarformulario.js"></script>
</body>
</html>
