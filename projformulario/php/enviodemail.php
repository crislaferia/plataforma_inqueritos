<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Input Form</title>
    <style>
      body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #container {
            width: 80%; /* Ajuste conforme necessário */
            max-width: 600px; /* Define uma largura máxima para o conteúdo */
            background-color: #f9f9f9; /* Cor de fundo opcional */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra opcional */
        }

        /* Adicionando estilos básicos para o modal */
        #myModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #modalContent {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="container">
<div class="janelaenvio">
    <h2>Envio de Email Pré Defenido</h2>

    <form id="emailForm" action="phpligaemail.php" method="post">
        <input type="email" id="emailInput" name="emails" placeholder="Insira os e-mails">
        <button type="button" onclick="adicionarEmail()">Adicionar</button>
        <div type="email" id="emailsContainer" name="email"></div>
        <button type="submit">Enviar</button>
        <button type="button" onclick="limparFormulario()">Limpar</button>
    </form>
    <!-- Modal para exibir a resposta do servidor -->
    <div id="myModal">
        <div id="modalContent"></div>
    </div>
</div>
</div>

    <script>
        const emailInput = document.getElementById("emailInput");
        const emailsContainer = document.getElementById("emailsContainer");
        const emailForm = document.getElementById("emailForm");
        const modal = document.getElementById("myModal");
        const modalContent = document.getElementById("modalContent");

        function adicionarEmail() {
            const valor = emailInput.value.trim();
            if (valor !== "") {
                const novoEmail = document.createElement("span");
                novoEmail.textContent = valor;
                novoEmail.setAttribute("contentEditable", "true");

                emailsContainer.appendChild(novoEmail);

                if (emailsContainer.textContent !== "") {
                    emailsContainer.innerHTML += "; ";
                }

                emailInput.value = "";
            }
        }

        emailForm.addEventListener("submit", function(event) {
            event.preventDefault();

            // Remover botões de remoção antes de enviar os e-mails
            const removeButtons = document.querySelectorAll('.removeButton');
            removeButtons.forEach(button => {
                button.parentNode.removeChild(button);
            });

            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "emails";
            hiddenInput.value = Array.from(emailsContainer.children).filter(element => element.nodeName === "SPAN").map(element => element.textContent).join(',');

            emailForm.appendChild(hiddenInput);

            // Enviar o formulário com os dados para o servidor
            fetch('phpligaemail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(emailForm)).toString(),
            })
            .then(response => response.text())
            .then(data => {
                // Exibir a resposta do servidor no modal
                modalContent.textContent = data;
                modal.style.display = "flex";
            })
            .catch(error => {
                console.error('Erro ao enviar e-mails:', error);
            });
        });

        // Fechar o modal quando clicar fora dele
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        function limparFormulario() {
            // Remover os elementos span do emailsContainer
            const spans = emailsContainer.querySelectorAll('span');
            spans.forEach(span => {
                emailsContainer.removeChild(span);
            });

            // Remover o ponto e vírgula (;) do emailsContainer, se existir
            const content = emailsContainer.textContent.trim();
            if (content.endsWith(";")) {
                emailsContainer.textContent = content.slice(0, -1);
            }

            // Limpar o valor do emailInput
            emailInput.value = "";
        }
    </script>

</body>
</html>
