<?php
require_once("../requires/connect.php");

// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS

$senha = hash('md5', $_POST['senha']);
$pass_recovery = $_POST['pass_recovery'];

$update = "UPDATE Usuario SET senha = '$senha' WHERE pass_recovery = '$pass_recovery'";
if ($mysqli->query($update) === TRUE) {
	echo "<script>
		  alert('Troca Realizada com sucesso!');
		  window.location.href='../../index.html';
		  </script>";
} else {
   	echo "<script>
		  alert('Falha ao realizar troca, tente novamente.');
		  window.location.href='definir_senha.php';
		  </script>";

 //  echo "Error updating record: " . $conn->error; // DEBUG
}

$mysqli->close(); // fecha a conexao
?>
	