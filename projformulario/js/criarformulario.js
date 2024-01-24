document.addEventListener('DOMContentLoaded', () => {
  const columns = document.querySelectorAll('.column');
  const items = document.querySelectorAll('.item');
  let meuTexto = '';
  const perguntasPorContainer = {};
  let draggedItem = null;
  let originalIndex = null;
  let containerCreated = false;
  let contadorPerguntas = 0;

  items.forEach((item, index) => {
    item.addEventListener('dragstart', (e) => {
      draggedItem = item;
      originalIndex = index;

      setTimeout(() => {
        item.classList.add('dragging');
      }, 0);
    });

    item.addEventListener('dragend', () => {
      setTimeout(() => {
        draggedItem.classList.remove('dragging');
        draggedItem = null;

        if (!isDroppedInSecondColumn()) {
          const currentIndex = Array.from(columns[0].children).indexOf(item);
          if (originalIndex !== currentIndex) {
            columns[0].insertBefore(item, columns[0].children[originalIndex]);
          }
        }
        containerCreated = false;
      }, 0);
    });
  });

  function isDroppedInSecondColumn() {
    return Array.from(columns[1].children).includes(draggedItem);
  }

  columns.forEach((column) => {
    column.addEventListener('dragover', (e) => {
      e.preventDefault();

      if (containerCreated) {
        return;
      }

      const afterElement = getDragAfterElement(column, e.clientY);
      const draggable = document.querySelector('.dragging');
      if (afterElement == null) {
        column.appendChild(draggable);
      } else {
        column.insertBefore(draggable, afterElement);
      }

      // ARRASTAR PARA A COLUNA DA DIREITA

      if (column.classList.contains('second-column') && draggable && draggedItem.textContent === 'Botões de escolha') {
        createRadioGroup(column.querySelector('.radio-group-container'));
        containerCreated = true;
      } else if
        (column.classList.contains('second-column') && draggable && draggedItem.textContent === 'Pergunta simples') {
        createSimpleQuestionGroup(column.querySelector('.radio-group-container'));
        containerCreated = true;
      } else if (column.classList.contains('second-column') && draggable && draggedItem.textContent === 'Pontuacao') {
        createEvaluationGroup(column.querySelector('.radio-group-container'));
        containerCreated = true;
      } else if (column.classList.contains('second-column') && draggable && draggedItem.textContent === 'Observações') {
        createObservationsGroup(column.querySelector('.radio-group-container'));
        containerCreated = true;
      }
    });



  });

  function getDragAfterElement(column, y) {
    const draggableElements = [...column.querySelectorAll('.item:not(.dragging)')];
    return draggableElements.reduce(
      (closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
          return { offset, element: child };
        } else {
          return closest;
        }
      },
      { offset: Number.NEGATIVE_INFINITY }
    ).element;
  }

  document.addEventListener('dragover', (e) => {
    e.preventDefault();
  });

  document.addEventListener('drop', (e) => {
    e.preventDefault();
  });


  //CRIAR CONTAINER "BOTÕES DE ESCOLHA"

  function createRadioGroup(container) {
    const radioGroup = document.createElement('div');
    const containerId = `container-${Date.now()}`;// Identificador único
    radioGroup.classList.add('radio-group');
    radioGroup.dataset.id = containerId; // Adiciona o identificador como atributo de dados


    ++contadorPerguntas;
    const questionNumber = contadorPerguntas; // Incrementa o contador global
    radioGroup.appendChild(createQuestionText(`Pergunta ${questionNumber}`)); // Adiciona o texto da pergunta

    const textInput = document.createElement('input');
    textInput.type = 'text';
    textInput.classList.add('question-input');
    textInput.placeholder = 'Digite sua pergunta';

    //ADICIONAR TEXTO DA PERGUNTA PARA CAMBIO C/GUARDAR 

    textInput.addEventListener('input', () => {
      // Atualizar o valor da variável com o texto do input
      const containerId = radioGroup.dataset.id;
      perguntasPorContainer[containerId] = textInput.value;
      console.log('Texto digitado:', perguntasPorContainer);
      // Agora, "meuTexto" contém o texto atual do input

    });


    const addButton = document.createElement('button');
    addButton.classList.add('action-button');
    addButton.textContent = '+';
    addButton.addEventListener('click', () => {
      const newOption = createRadioButton('Nova Opção');
      radioGroup.appendChild(newOption);
      updateRemoveButtonVisibility();
    });

    const removeButton = document.createElement('button');
    removeButton.classList.add('action-button');
    removeButton.textContent = '-';
    removeButton.addEventListener('click', () => {
      const lastOption = radioGroup.lastChild;
      if (lastOption) {
        radioGroup.removeChild(lastOption);
        updateRemoveButtonVisibility();
      }
    });

    const removeContainerButton = document.createElement('button');
    removeContainerButton.classList.add('delete-button');
    removeContainerButton.textContent = 'Apagar';
    removeContainerButton.addEventListener('click', () => {
      removeRadioGroup(containerId); // Chama removeRadioGroup com o identificador único
    });

    radioGroup.appendChild(textInput);
    radioGroup.appendChild(addButton);
    radioGroup.appendChild(removeButton);
    radioGroup.appendChild(removeContainerButton);

    //PARA ADICIONAR APENAS UM RADIO BUTTON
    /*
    // Adiciona o primeiro radio button
    const initialOption = createRadioButton('editar');
    radioGroup.appendChild(initialOption);
    */


    for (let i = 1; i <= 4; i++) {
      const newOption = createRadioButton(`Opção ${i}`);
      radioGroup.appendChild(newOption);
    }

    container.appendChild(radioGroup);

    // controlar botão '-' para que não se possa eliminar menos de 1 radio button
    function updateRemoveButtonVisibility() {
      removeButton.style.display = radioGroup.children.length > 3 ? 'block' : 'none';
      // Exibe o botão se houver mais de um radio button 
    }
  }

  function createRadioButton(label) {
    const labelElement = document.createElement('label');
    const inputElement = document.createElement('input');

    const labelSpan = document.createElement('span');
    labelSpan.contentEditable = true; // Torna o conteúdo editável
    labelSpan.textContent = label;

    inputElement.type = 'radio';
    inputElement.name = `radio-group-${Date.now()}`;

    labelElement.appendChild(inputElement);
    labelElement.appendChild(labelSpan);

    // Adiciona um evento para lidar com a edição do texto
    labelSpan.addEventListener('input', () => {
      console.log('Texto do radio button editado:', labelSpan.textContent);
    });

    return labelElement;
  }

  function removeRadioGroup(containerId) {
    const containerToRemove = document.querySelector(`[data-id="${containerId}"]`);
    if (containerToRemove) {
      containerToRemove.remove();
      --contadorPerguntas;
    }
  }


  // PERGUNTA SIMPLES 

  function createSimpleQuestionGroup(container) {
    const simpleQuestionGroup = document.createElement('div');
    const containerId = `container-${Date.now()}`;
    simpleQuestionGroup.classList.add('simple-question-group');
    simpleQuestionGroup.dataset.id = containerId;

    ++contadorPerguntas;
    const questionNumber = contadorPerguntas; // Incrementa o contador global
    simpleQuestionGroup.appendChild(createQuestionText(`Pergunta ${questionNumber}`)); // Adiciona o texto da pergunta

    const textInput1 = document.createElement('input');
    textInput1.type = 'text';
    textInput1.classList.add('question-input');
    textInput1.placeholder = 'Digite sua pergunta';

    const textInput2 = document.createElement('input');
    textInput2.type = 'text';
    textInput2.classList.add('response-user');
    textInput2.placeholder = 'Resposta do usuário';

    textInput2.readOnly = true;

    textInput1.addEventListener('input', () => {
      // Atualizar o valor da variável com o texto do input
      const containerId = simpleQuestionGroup.dataset.id;
      perguntasPorContainer[containerId] = textInput1.value;
      console.log('Texto digitado:', perguntasPorContainer);
    });

    const removeContainerButton = document.createElement('button');
    removeContainerButton.classList.add('delete-button');
    removeContainerButton.textContent = 'Apagar';
    removeContainerButton.addEventListener('click', () => {
      removeSimpleQuestionGroup(containerId);
    });

    simpleQuestionGroup.appendChild(textInput1);
    simpleQuestionGroup.appendChild(textInput2);
    simpleQuestionGroup.appendChild(removeContainerButton);

    container.appendChild(simpleQuestionGroup);
  }

  function removeSimpleQuestionGroup(containerId) {
    const containerToRemove = document.querySelector(`[data-id="${containerId}"]`);
    if (containerToRemove) {
      containerToRemove.remove();
      --contadorPerguntas;
    }
  }


  //PONTUACAO 

  function createEvaluationGroup(container) {
    const evaluationGroup = document.createElement('div');
    const containerId = `container-${Date.now()}`;
    evaluationGroup.classList.add('evaluation-group');
    evaluationGroup.dataset.id = containerId;

    ++contadorPerguntas;
    const questionNumber = contadorPerguntas; // Incrementa o contador global
    evaluationGroup.appendChild(createQuestionText(`Pergunta ${questionNumber}`)); // Adiciona o texto da pergunta

    const textInput = document.createElement('input');
    textInput.type = 'text';
    textInput.classList.add('question-input');
    textInput.placeholder = 'Digite sua pergunta';

    textInput.addEventListener('input', () => {
      // Atualizar o valor da variável com o texto do input
      const containerId = evaluationGroup.dataset.id;
      perguntasPorContainer[containerId] = textInput.value;
      console.log('Texto digitado:', perguntasPorContainer);
    });

    evaluationGroup.appendChild(textInput);

    // Adiciona 5 radio buttons
    for (let i = 1; i <= 5; i++) {
      const labelElement = document.createElement('label');
      const inputElement = document.createElement('input');
      inputElement.type = 'radio';
      inputElement.name = `radio-group-${containerId}`;
      inputElement.value = i;

      const labelSpan = document.createElement('span');
      labelSpan.textContent = ` ${i} `;

      labelElement.appendChild(inputElement);
      labelElement.appendChild(labelSpan);

      evaluationGroup.appendChild(labelElement);
    }

    const removeContainerButton = document.createElement('button');
    removeContainerButton.classList.add('delete-button');
    removeContainerButton.textContent = 'Apagar';
    removeContainerButton.addEventListener('click', () => {
      removeEvaluationGroup(containerId);
    });

    evaluationGroup.appendChild(removeContainerButton);

    container.appendChild(evaluationGroup);
  }


  function removeEvaluationGroup(containerId) {
    const containerToRemove = document.querySelector(`[data-id="${containerId}"]`);
    if (containerToRemove) {
      containerToRemove.remove();
      --contadorPerguntas;
    }
  }

  // OBSERVACOES

  function createObservationsGroup(container) {
    const observationsGroup = document.createElement('div');
    const containerId = `container-${Date.now()}`;
    observationsGroup.classList.add('observations-group');
    observationsGroup.dataset.id = containerId;

    const observationsText = createQuestionText('Observações');
    observationsText.contentEditable = true; // Torna o conteúdo editável
    observationsGroup.appendChild(observationsText)
    observationsText.classList.add('text-editable')

    const textInput = document.createElement('input');
    textInput.type = 'text';
    textInput.classList.add('observations-input');
    textInput.placeholder = 'edite o texto';
    //textInput.dataset.editable = 'false'; // Adiciona um atributo para rastrear a editabilidade
    textInput.style.border = '1px solid #ccc'; // Adiciona uma borda para indicar que não é editável
    textInput.style.padding = '5px';
    textInput.style.cursor = 'default'; // Adiciona um cursor padrão para indicar que não é editável
    textInput.style.height = '150px'; // Define a altura desejada, ajuste conforme necessário
    textInput.style.width = '250px';

    textInput.readOnly = true;

    const removeContainerButton = document.createElement('button');
    removeContainerButton.classList.add('delete-button');
    removeContainerButton.textContent = 'Apagar';
    removeContainerButton.addEventListener('click', () => {
      removeObservationsGroup(containerId);
    });

    observationsGroup.appendChild(textInput);
    observationsGroup.appendChild(removeContainerButton);

    container.appendChild(observationsGroup);
  }

  function removeObservationsGroup(containerId) {
    const containerToRemove = document.querySelector(`[data-id="${containerId}"]`);
    if (containerToRemove) {
      containerToRemove.remove();
    }
  }


  function createQuestionText(text) {
    const questionText = document.createElement('div');
    questionText.textContent = text;
    questionText.classList.add('question-text');
    return questionText;
  }

  // GUARDAR E GERAR LINK 

  const saveButton = document.querySelector('button');
  saveButton.addEventListener('click', () => {
    // Remover botões específicos após salvar o formulário
    //"BOTÕES DE ESCOLHA"
    const radioGroupContainers = document.querySelectorAll('.radio-group-container');
    radioGroupContainers.forEach(container => {
      const buttonsToRemove = container.querySelectorAll('.action-button');
      buttonsToRemove.forEach(button => {
        button.remove();
      });
    });

    // ...
    const editableElements = document.querySelectorAll('.question-input');
    editableElements.forEach(element => {
      if (element.tagName.toLowerCase() === 'input' && element.type === 'text') {
        // Se for um input de texto, torná-lo readonly
        //element.readOnly = true;
        //element.removeAttribute('placeholder');
      } else {
        // Caso contrário, torná-lo não editável (para outros tipos de elementos)
        element.setAttribute('contenteditable', 'false');

      }

      const meuDocumento = { titulo: 'Meu Formulário', conteudoHTML: '...' };
      inserirDocumento('formularios', meuDocumento);
      consultarDocumentos('formularios');
    });
    // Aguardar um curto período (ex: 100ms) antes de salvar o formulário
    setTimeout(() => {
      saveForm();
    }, 100);
  });


  function saveForm() {


    const formTitle = document.getElementById('form-title').value;
    const fileName = formTitle.replace(/[^\w\s]/gi, '').replace(/\s+/g, '_');
    // Obtém o conteúdo HTML da segunda coluna que contém os elementos do formulário
    const formContentClone = columns[1].cloneNode(true);

    const formTitleText = document.createElement('p');
    formTitleText.textContent = `Título do formulário: ${formTitle}`;
    formContentClone.insertBefore(formTitleText, formContentClone.firstChild);

    const formTitleClone = formContentClone.querySelector('#form-title');
    if (formTitleClone) {
      formTitleClone.remove();
    }

    const titleLabelClone = formContentClone.querySelector('.label[for="form-title"]');
    if (titleLabelClone) {
      titleLabelClone.remove();
    }

    const elementsToRemove = formContentClone.querySelectorAll('.question-input');
    elementsToRemove.forEach(element => {
      element.remove();
    });

    const buttonDeleteRemove = formContentClone.querySelectorAll('.delete-button');
    buttonDeleteRemove.forEach(element => {
      element.remove();
    });

    Object.entries(perguntasPorContainer).forEach(([containerId, pergunta]) => {
      const container = formContentClone.querySelector(`[data-id="${containerId}"]`);
      if (container) {
        const questionInput = container.querySelector('.question-text');
        const newParagraph = document.createElement('p');
        newParagraph.textContent = pergunta;
        questionInput.appendChild(newParagraph);
      }
    });

    const responseUserInputs = formContentClone.querySelectorAll('.response-user');
    responseUserInputs.forEach(input => {
      input.removeAttribute('readonly');
    });



    const observationsUserInputs = formContentClone.querySelectorAll('.observations-input');
    observationsUserInputs.forEach(input => {
      input.removeAttribute('readonly');
    });

    const textObservationInput = formContentClone.querySelectorAll('.text-editable');
    textObservationInput.forEach(input => {
      input.removeAttribute('contentEditable');
    });

    const radioGroupContainers = formContentClone.querySelectorAll('.radio-group');
    radioGroupContainers.forEach(container => {
      const containerId = container.dataset.id;
      const questionTextElement = container.querySelector('.question-text');
      const newParagraph = document.createElement('p');
      newParagraph.textContent = meuTexto; // Utiliza o texto da pergunta
      questionTextElement.appendChild(newParagraph);
    });


    // Cria o conteúdo completo do arquivo HTML
    const htmlContent = `<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Formulário Salvo</title>
      <link rel="stylesheet" href="/css/criarformulario.css" />
    </head>
    <body>
    ${formContentClone.innerHTML}
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          // Inserir código JS dinâmico para restaurar a edição dos rótulos, se necessário
        });
      </script>
    </body>
    </html>`;

    // Cria um objeto Blob com o conteúdo HTML
    const blob = new Blob([htmlContent], { type: 'text/html' });

    // Cria um link de download para o arquivo HTML
    const linkDownload = document.createElement('a');
    linkDownload.href = window.URL.createObjectURL(blob);
    linkDownload.download = `${fileName}.html`;

    // Simula um clique no link para iniciar o download
    linkDownload.click();
  }

  //LIGACAO MONGODB

  const { MongoClient } = require('mongodb');
  // ... (restante do código)

  const uri = 'mongodb://localhost:27017/plataformaiInqueritos'; // Substitua com o URI de conexão ao seu MongoDB
  const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

  // Função para conectar ao MongoDB
  async function conectarAoMongoDB() {
    try {
      await client.connect();
      console.log('Conectado ao MongoDB');
    } catch (erro) {
      console.error('Erro ao conectar ao MongoDB:', erro);
    }
  }

  // Função para fechar a conexão
  async function fecharConexao() {
    await client.close();
    console.log('Conexão fechada');
  }

  // Função para inserir documento no MongoDB
  async function inserirDocumento(teste, meuDocumento) {
    const db = client.db();
    const collection = db.collection(teste);

    try {
      const resultado = await collection.insertOne(meuDocumento);
      console.log('Documento inserido:', resultado.insertedId);
    } catch (erro) {
      console.error('Erro ao inserir documento:', erro);
    }
  }

  // Função para consultar documentos no MongoDB
  async function consultarDocumentos(teste) {
    const db = client.db();
    const collection = db.collection(teste);

    try {
      const documentos = await collection.find().toArray();
      console.log('Documentos encontrados:', documentos);
    } catch (erro) {
      console.error('Erro ao consultar documentos:', erro);
    }
  }

  // Restante do código...

  // Lembre-se de fechar a conexão quando não precisar mais
  // fecharConexao();

});

