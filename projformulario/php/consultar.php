<?php
// Conectar ao MongoDB
require '/laragon/www/projformulario/php/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost');
$databaseName = 'plataformaiInqueritos';
$collectionName = 'questionarios';
$collection = $client->$databaseName->$collectionName;

// Consultar os dados do MongoDB para obter as opções do seletor
$resultado = $collection->find(); // Use find() para obter vários documentos
$options = "<option value='0'>Selecione o formulário:</option>";

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="white-box"></div>
<h1>CONSULTAR FORMULÁRIOS</h1>

<p>
    <div class="input-group">
        <select class="spinner">
            <?php echo $options; ?>
        </select>
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" onclick="link2">Editar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup('php/enviodemail.php')">Enviar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup2('<?php echo $linkCompleto; ?>')">Gerar Link</a></li>

            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Eliminar</a></li>
        </ul>
    </div>
</p>

<script>
    function openPopup(url) {
        window.open(url, 'popup', 'width=550px,height=200px');
    }

    function openPopup2(message) {
        Swal.fire({
            title: 'LINK',
            html: message,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }
</script>
