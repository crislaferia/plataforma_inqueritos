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
        $id = isset($documento['_id']) ? $documento['_id'] : '';
        $descricao = isset($documento['descricao']) ? $documento['descricao'] : '';

        $idString = (string) $id;

        $options .= "<option class='form-selector-option' data-id='" . $idString . "' value='" . $idString . "'>" . $descricao . "</option>";
    }
}
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
        <form id="formularioEnviar" action="enviodemail.php" method="post">
            <select id="formSelector" class="spinner">
                <option value='0' selected>Selecione o formulário:</option>
                <?php echo $options; ?>
            </select>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" onclick="">Editar</a></li>
                <li><a class="dropdown-item" href="#" onclick="enviarFormulario()">Enviar</a></li>
                <li><a class="dropdown-item" href="#" onclick="openPopup2()">Gerar Link</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="eliminarOpcao()">Eliminar</a></li>
            </ul>
            <!-- Campo de formulário oculto para armazenar o valor de $idSelecionado -->
            <input type="hidden" name="idSelecionado" id="idSelecionado">
        </form>
    </div>
</p>

<script>
    var valorSelecionado;

    function onSpinnerChange() {
        valorSelecionado = $('#formSelector').val();
        console.log("Valor selecionado1:", valorSelecionado);

        if (valorSelecionado) {
            console.log("Valor selecionado2:", valorSelecionado);
        } else {
            console.warn("Nenhum valor selecionado no spinner.");
        }
    }

    function enviarFormulario() {
        // Obtenha o valor selecionado no seletor
        var valorSelecionado = $('#formSelector').val();

        // Certifique-se de que o valor não seja '0' ou vazio
        if (valorSelecionado && valorSelecionado.trim() !== '0') {
            console.log("Enviando valor:", valorSelecionado);

            // Desabilitar o botão durante o processamento
            $("#enviarBtn").prop("disabled", true);

            // Abra o popup antes de enviar o valor via AJAX para enviodemail.php
// Abra o popup antes de enviar o valor via AJAX para enviodemail.php
window.open('php/enviodemail.php?idmongo=' + valorSelecionado, 'popup', 'width=550px,height=200px');

            // Envie o valor via AJAX para enviodemail.php
            $.ajax({
                type: "GET",
                url: "php/enviodemail.php",
                data: { idmongo: valorSelecionado },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error("Erro na requisição AJAX:", error);
                },
                complete: function () {
                    // Reativar o botão após o processamento
                    $("#enviarBtn").prop("disabled", false);
                }
            });
        } else {
            console.warn("Nenhum valor selecionado no spinner.");
        }
    }

     function openPopup(url) {
        window.open(url, 'popup', 'width=550px,height=200px');
    } 

    function openPopup2() {
        var valorSelecionado = gerarLink();
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

    function gerarLink() {
        var valorSelecionado = $('#formSelector').val();
        if (valorSelecionado) {
            console.log("Gerando link para o valor selecionado:", valorSelecionado);

            linkNovoId = 'http://localhost/projformulario/php/pagina_respostas.php?id=' + valorSelecionado;
            openPopup(linkNovoId);
            return linkNovoId;
        } else {
            console.warn("Nenhuma opção selecionada para gerar link.");
        }
    }

    function eliminarOpcao() {
        console.log("Função eliminarOpcao() chamada.");

        var spinnerElement = $('#formSelector');
        console.log("Elemento do seletor:", spinnerElement);

        var valorSelecionado = spinnerElement.val();

        if (typeof valorSelecionado === 'string' && valorSelecionado.trim() !== '0') {
            console.log("Valor selecionado:", valorSelecionado);

            var confirmarRemocao = confirm("Tem certeza de que deseja remover esta opção?");
            if (confirmarRemocao) {
                console.log("Usuário confirmou a remoção.");

                $.ajax({
                    type: "POST",
                    url: "php/remover_opcao.php",
                    data: { id: valorSelecionado },
                    success: function (response) {
                        console.log("Resposta do servidor:", response);
                        if (response.toLowerCase().includes("success")) {
                            $("#formSelector option[value='" + valorSelecionado + "']").remove();
                            console.log("Opção removida com sucesso.");
                            alert("Opção removida com sucesso.");
                            location.reload();
                        } else {
                            console.error("Erro ao remover a opção do MongoDB. Resposta do servidor:", response);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("Erro na solicitação AJAX. Status:", textStatus, "Erro:", errorThrown);
                        console.log("Resposta completa:", jqXHR.responseText);
                    }
                });
            }
        }
    }

    $(document).ready(function () {
        $('#formSelector').on('change', function () {
            var selectedValue = $(this).val();
            $('#idSelecionado').val(selectedValue);
        });
    });
</script>
