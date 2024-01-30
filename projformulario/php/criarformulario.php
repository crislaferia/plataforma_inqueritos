<!-- php/criarformulario.php -->

<div class="kanban" style="font-family: Arial, sans-serif">
  <div class="column first-column">
    <div class="item" draggable="true">Botões de escolha</div>
    <div class="item" draggable="true">Pergunta simples</div>
    <div class="item" draggable="true">Pontuacao</div>
    <div class="item" draggable="true">Observações</div>
  </div>
  <div class="column second-column">
    <div class="form-title-section">
      <label style="color: black;" class="label" for="form-title" style="color: #F5F8FA;">Título do Formulário: </label>
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

<script src="js/criarformulario.js"></script>
