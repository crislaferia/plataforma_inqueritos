<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Formulário</title>
</head>
<body>
    <h1>Editor de Formulário</h1>
    <div id="formContainer">
        <!-- Os campos do formulário serão preenchidos dinamicamente pelo JavaScript -->
    </div>

    <button onclick="addQuestion()">Adicionar Pergunta</button>
    <button onclick="removeSelectedQuestions()">Remover Perguntas Selecionadas</button>

    <script>
        var questionCount = 0; // Contador de perguntas adicionadas

        // Função para adicionar uma nova pergunta ao formulário
function addQuestion() {
    questionCount++;

    var formContainer = document.getElementById("formContainer");
    var newQuestionDiv = document.createElement("div");
    newQuestionDiv.classList.add("dynamic-question"); // Adiciona a classe "dynamic-question" à nova pergunta
    var questionId = "question" + questionCount; // Gerar ID único para a nova pergunta
    newQuestionDiv.id = questionId;
    newQuestionDiv.innerHTML = "<input type='checkbox' id='" + questionId + "Checkbox' name='" + questionId + "Checkbox'>" +
                                "<label for='" + questionId + "Checkbox'>Remover</label><br>" +
                                "<label for='" + questionId + "'>Pergunta " + questionCount + "</label><br>" +
                                "<input type='text' id='" + questionId + "' name='" + questionId + "'><br>" +
                                "<label for='" + questionId + "Type'>Tipo de Pergunta</label><br>" +
                                "<select id='" + questionId + "Type' name='" + questionId + "Type' onchange='toggleOptionsInput(\"" + questionId + "\")'>" +
                                "<option value='simple-question-group'>Texto</option>" +
                                "<option value='radio-group'>Seleção Única</option>" +
                                "<option value='evaluation-group'>Avaliação</option>" +
                                "<option value='observations-group'>Observações</option>" +
                                "</select><br>" +
                                "<div id='" + questionId + "Options'></div><br>";
    formContainer.appendChild(newQuestionDiv);
}

// Função para preencher os campos do formulário com base nos dados recuperados do MongoDB
function fillForm(data) {
    var formContainer = document.getElementById("formContainer");
    var html = "<form id='formEditor' action='submit.php' method='post'>";
    
    html += "<label for='formTitle'>Título do Formulário</label><br>";
    html += "<input type='text' id='formTitle' name='formTitle' value='" + data.title + "'><br><br>";

    for (var key in data) {
        if (key !== "_id" && key !== "title") {
            var field = data[key];
            var questionId = key + "Question";

            html += "<div id='" + questionId + "Div' class='questionDiv'>";
            html += "<input type='checkbox' id='" + key + "Checkbox' name='" + key + "Checkbox'>" +
                    "<label for='" + key + "Checkbox'>Remover</label><br>";
            html += "<label for='" + questionId + "'>Pergunta</label><br>";
            html += "<input type='text' id='" + questionId + "' name='" + questionId + "' value='" + field.question + "'><br>";

            html += "<label for='" + key + "Type'>Tipo de Pergunta</label><br>";
            html += "<select id='" + key + "Type' name='" + key + "Type' onchange='toggleOptionsInput(\"" + key + "\")'>";
            html += "<option value='simple-question-group'>Texto</option>";
            html += "<option value='radio-group'>Seleção Única</option>";
            html += "<option value='evaluation-group'>Avaliação</option>";
            html += "<option value='observations-group'>Observações</option>";
            html += "</select><br>";

            // Adicionar opções para perguntas de seleção única e avaliação
            if (field.type === "radio-group" || field.type === "evaluation-group") {
                html += "<div id='" + key + "Options'>";
                for (var i = 0; i < field.options.length; i++) {
                    html += "<input type='text' name='" + key + "Option" + i + "' value='" + field.options[i] + "'><br>";
                }
                html += "<button type='button' onclick='addOption(\"" + key + "\")'>Adicionar Opção</button><br>";
                html += "</div>";
            } else {
                html += "<div id='" + key + "Options'></div>"; // Adicione um contêiner vazio para opções
            }

            html += "</div><br>";
        }
    }

    html += "<input type='submit' value='Salvar Como Novo'>";
    html += "</form>";

    formContainer.innerHTML = html;
}

// Função para remover as perguntas selecionadas
function removeSelectedQuestions() {
    var formContainer = document.getElementById("formContainer");

    // Selecionar e remover todas as perguntas marcadas para remoção
    var checkboxes = formContainer.querySelectorAll(".questionDiv input[type='checkbox']");
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            var questionDiv = checkbox.parentNode;
            formContainer.removeChild(questionDiv);
            questionCount--;
        }
    });
}





        // Função para alternar a exibição do campo de opções de resposta
        function toggleOptionsInput(fieldKey) {
            var selectElement = document.getElementById(fieldKey + "Type");
            var optionsDiv = document.getElementById(fieldKey + "Options");
            optionsDiv.innerHTML = ""; // Limpar opções existentes

            if (selectElement.value === "radio-group" || selectElement.value === "evaluation-group") {
                // Adicionar opções de entrada
                var optionCount = selectElement.value === "radio-group" ? 4 : 5; // Defina um número padrão de opções
                for (var i = 0; i < optionCount; i++) {
                    var input = document.createElement("input");
                    input.type = "text";
                    input.name = fieldKey + "Option" + i;
                    optionsDiv.appendChild(input);
                    optionsDiv.appendChild(document.createElement("br"));
                }

                // Adicionar botão para adicionar mais opções
                var addButton = document.createElement("button");
                addButton.type = "button";
                addButton.textContent = "Adicionar Opção";
                addButton.onclick = function() {
                    var input = document.createElement("input");
                    input.type = "text";
                    input.name = fieldKey + "Option" + (optionsDiv.getElementsByTagName("input").length / 2);
                    optionsDiv.appendChild(input);
                    optionsDiv.appendChild(document.createElement("br"));
                };
                optionsDiv.appendChild(addButton);
            }
        }

        // Fazer uma solicitação AJAX para recuperar os dados do formulário do servidor
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getFormData.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var formData = JSON.parse(xhr.responseText);
                fillForm(formData);
            }
        };
        xhr.send();
    </script>
</body>
</html>
