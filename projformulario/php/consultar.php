<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="white-box"></div>
<h1>CONSULTAR FORMULÁRIOS</h1>

<p>
    <div class="input-group">
        <select class="spinner">
            <option value="0">Selecione o formulário:</option>
            <option value="1">Informática</option>
            <option value="2">Cerâmica</option>
            <option value="3">Multimédia</option>
            <option value="4">Pintura</option>
            <option value="5">Formadores</option>
            <option value="6">Avaliação Módulos</option>
            <option value="7">Condições da Escola</option>
            <option value="8">Cantina</option>
        </select>
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opções</button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" onclick="openPopup3('php/enviodemail.php')">Editar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup('php/enviodemail.php')">Enviar</a></li>
            <li><a class="dropdown-item" href="#" onclick="openPopup2('aqui vai o link gerado')">Gerar Link</a></li>
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
function openPopup3(url) {
    // Faz uma requisição AJAX para obter o conteúdo da página HTML
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            // Exibe o conteúdo da página HTML dentro do modal
            Swal.fire({
                title: 'Popup Title',
                html: data,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        },
        error: function () {
            // Em caso de erro ao carregar a página
            Swal.fire({
                title: 'Erro',
                text: 'Não foi possível carregar o conteúdo da página.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}


</script>
