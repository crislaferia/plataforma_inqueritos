<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Input Form</title>
</head>
<body>

    <h2>Insira os Emails</h2>
    
    <div id="emailsContainer" onclick="editarEmail(event)"></div>
    <input type="text" id="emailInput" placeholder="Insira os e-mails">

    <script>
        const emailsContainer = document.getElementById("emailsContainer");
        const emailInput = document.getElementById("emailInput");

        emailInput.addEventListener("keydown", function(event) {
            const inputValue = emailInput.value.trim();
            const lastChar = inputValue.slice(-1);

            if (event.key === " " || event.key === "Enter" || event.key === "," || event.key === ";" || event.key === "Tab") {
                event.preventDefault(); // Impede a adição do espaço, quebra de linha, vírgula, ponto e vírgula ou tabulação no campo
                if (lastChar !== "") {
                    adicionarEmail(inputValue);
                    emailInput.value = ""; // Limpar o campo após adicionar o e-mail
                }
            }
        });

        emailInput.addEventListener("paste", function(event) {
            event.preventDefault();

            const clipboardData = event.clipboardData || window.clipboardData;
            const pastedText = clipboardData.getData("text");

            const emails = pastedText.split(/[\s,;]+/);
            emails.forEach(email => {
                if (email.trim() !== "") {
                    adicionarEmail(email.trim());
                }
            });
        });

        function adicionarEmail(valor) {
            const novoEmail = document.createElement("span");
            novoEmail.textContent = valor; // Pode ser valor padrão ou o valor do campo
            novoEmail.setAttribute("contentEditable", "true"); // Torna o e-mail editável
            emailsContainer.appendChild(novoEmail);

            // Adicionar uma vírgula e espaço se já houver e-mails anteriores
            if (emailsContainer.textContent !== "") {
                emailsContainer.innerHTML += ", ";
            }
        }

        function editarEmail(event) {
            const target = event.target;
            if (target.tagName === "SPAN" && target.getAttribute("contentEditable") === "true") {
                target.focus(); // Focar no e-mail clicado para edição
            }
        }
    </script>

</body>
</html>
