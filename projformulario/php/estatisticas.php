<?php
// Conectar ao MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaInqueritos';
$collectionName = 'respostas';
$collection = $client->$databaseName->$collectionName;

// Consultar os dados do MongoDB para obter as opções do seletor
$resultado = $collection->find(); // Use find() para obter vários documentos
$options = " ";

if ($resultado) {
    foreach ($resultado as $documento) {
        $id = isset($documento['_id']) ? $documento['_id'] : '';
        $title = isset($documento['title']) ? $documento['title'] : '';

        $idString = (string) $id;

        $options .= "<option class='form-selector-option' data-id='" . $idString . "' value='" . $idString . "'>" . $title . "</option>";
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
<h1>Estatisticas Graficos</h1>

<p>
    <div class="input-group">
        <form id="formularioEnviar" action="enviodemail.php" method="post">
            <select id="formSelector" class="spinner">
                <option value='0' selected>Selecione o formulário:</option>
                <?php echo $options; ?>
            </select>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
            <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" onclick="openPopup('php/pagina_graficos.php', event)">Abrir Gráfico</a></li>
            <li><a class="dropdown-item" href="#" onclick="mostrarGrafico('php/pagina_graficos.php')">Visualizar Gráfico</a></li>
            <li><a class="dropdown-item" href="#" onclick="mostrarInq('php/pagina_respondidos.php')">Visualizar Respondido</a></li>

                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="eliminarOpcao()">Eliminar</a></li>
            </ul>
            <!-- Campo de formulário oculto para armazenar o valor de $idSelecionado -->
            <input type="hidden" name="idSelecionado" id="idSelecionado">
        </form>
    </div>
</p>

<!-- Elemento para mostrar a imagem do gráfico -->
<div id="graficoContainer"></div>

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
    function openPopup(url, event) {
    event.preventDefault();
    window.open(url, 'popup', 'width=550px,height=200px');
    }
    function mostrarGrafico(url) {
        // Atualiza o conteúdo da div com a imagem do gráfico
        $('#graficoContainer').html('<img src="' + url + '" alt="Gráfico">');
    }
    function mostrarInq(url) {
    // Obtém o valor selecionado no seletor
    var valorSelecionado = $('#formSelector').val();

    // Verifica se um valor foi selecionado
    if (valorSelecionado) {
        // Adiciona o valor do ID à URL
        url += '?id=' + valorSelecionado;

        // Faz a requisição AJAX para obter o conteúdo do arquivo PHP
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Atualiza o conteúdo da div com o conteúdo do arquivo PHP
                $('#graficoContainer').html(response);
            },
            error: function(xhr, status, error) {
                // Manipula erros, se necessário
                console.error('Erro ao carregar ' + url);
                console.log('XHR status:', status);
                console.log('XHR error:', error);
            }
        });
    } else {
        console.warn("Nenhum valor selecionado no spinner.");
    }
}




</script>