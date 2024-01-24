<?php
// Conectar ao MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Consultar os dados do MongoDB para obter as opções do seletor
$resultado = $collection->find(); // Use find() para obter vários documentos
$options = " ";

if ($resultado) {
    foreach ($resultado as $documento) {
        // Verificar se as chaves existem antes de acessá-las
        $valor = isset($documento['valor']) ? $documento['valor'] : '';
        $descricao = isset($documento['descricao']) ? $documento['descricao'] : '';

        $options .= "<option value='" . $valor . "'>" . $descricao . "</option>";
    }
}

$linkCompleto = isset($_SESSION['link']) ? $_SESSION['link'] : '';
?>

<!-- Seu código HTML/PHP continua aqui -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    if (typeof jQuery == 'undefined') {
        console.error('jQuery não está carregado.');
    }
</script>

<div class="white-box"></div>
<h1>CONSULTAR FORMULÁRIOS</h1>

<p>
    <div class="input-group">
    <select id="formSelector" class="spinner">
   <option value='0' selected>Selecione o formulário:</option>
    <?php echo $options; ?>
</select>
<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
<ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" onclick="link2">Editar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup('php/enviodemail.php')">Enviar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup2()">Gerar Link</a></li>

            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="eliminarOpcao()">Eliminar</a></li>        </ul>
    </div>
</p>

<script>
function openPopup(url) {
        window.open(url, 'popup', 'width=550px,height=200px');
    }

    function openPopup2() {
    var valorSelecionado = $('#formSelector').val();
    if (valorSelecionado) {
        Swal.fire({
            title: 'LINK',
            html: valorSelecionado,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    } else {
        console.warn("Nenhuma opção selecionada para gerar link.");
    }
}


function eliminarOpcao() {
    console.log("Função eliminarOpcao() chamada.");

    // Verificar se o seletor está sendo encontrado corretamente
    var spinnerElement = $('#formSelector');
    console.log("Elemento do seletor:", spinnerElement);

    // Obter o valor selecionado no seletor (spinner)
    var valorSelecionado = spinnerElement.val();
    
    // Certificar-se de que o valor é uma string não vazia e não é '0'
    if (typeof valorSelecionado === 'string' && valorSelecionado.trim() !== '0') {
        console.log("Valor selecionado:", valorSelecionado);

        // Confirmar a ação antes de prosseguir com a remoção
        var confirmarRemocao = confirm("Tem certeza de que deseja remover esta opção?");
        if (confirmarRemocao) {
            console.log("Usuário confirmou a remoção.");

            // Enviar solicitação AJAX para o script que remove a opção no servidor
            
            $.ajax({
    type: "POST",
    url: "/projformulario/php/remover_opcao.php",
    data: { valor: valorSelecionado },
    success: function (response) {
        console.log("Resposta do servidor:", response);
        if (response.toLowerCase().includes("success")) {
            // Remover a opção do seletor (spinner) no lado do cliente
            $("#formSelector option[value='" + valorSelecionado + "']").remove();
            console.log("Opção removida com sucesso.");
            alert("Opção removida com sucesso.");
            location.reload();
            // Opcionalmente, você pode recarregar a página ou executar outras ações
        } else {
            console.error("Erro ao remover a opção do MongoDB. Resposta do servidor:", response);
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error("Erro na solicitação AJAX. Status:", textStatus, "Erro:", errorThrown);
        console.log("Resposta completa:", jqXHR.responseText);
    }
});

        }}}
</script>
