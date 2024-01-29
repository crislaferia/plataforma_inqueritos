<?php
// Conectar à base de dados
include("ligaBD.php");

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
<style>
    
    </style>
<?php
// Consulta para obter utilizadores
$sql = "SELECT * FROM projeto_final_logins.tb_admins";
$result = $conn->query($sql);

// Exibir tabela de utilizadores
echo "<table border='1'>
        <tr>
          <th>cod_admin</th>
          <th>nome</th>
          <th>email</th>
          <th>password</th>
          <th>admin</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['cod_admin']}</td>
            <td>{$row['nome']}</td>
            <td>{$row['email']}</td>
            <td>{$row['password']}</td> <!-- Senha ocultada -->
            <td>{$row['admin']}</td>


            <td>
              <a href='edit_user.php?id={$row['cod_admin']}'>Editar</a>
              <a href='javascript:void(0);' onclick='confirmDelete({$row['cod_admin']})'>Excluir</a>
              </td>       
          </tr>";
          
}

echo "</table>";
echo "<a href='create_user.php'>Adicionar Novo Utilizador</a>";
echo "<a href='../index.php' class='back-button' style='margin-left: 785px;'>Voltar</a>";
?>
<script>
function confirmDelete(adminId) {
    var response = confirm("Tem certeza que deseja excluir este utilizador?");
    
    if (response) {
        window.location.href = 'delete_user.php?id=' + adminId;
    }
}
</script>
