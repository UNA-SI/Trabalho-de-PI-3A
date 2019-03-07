<?php
	require_once("../../requires/connect.php");
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
	$desc_op = $_POST['desc_op'];
	$tipo_op = $_POST['tipo_op'];

	$insert = "INSERT INTO operacao (desc_operacao, tipo) 
	VALUES('$desc_op', '$tipo_op')";
    
	if ($mysqli->query($insert) === TRUE) {
		echo "<script>
		alert('Opera\u00e7\u00e3o cadastrada com sucesso!');
		window.location.href='../cad_operacao.php';
		</script>";
	}else{
		echo "<script>
		alert('Ocorreu um erro ao cadastrar a Opera\u00e7\u00e3o, tente novamente!');
		window.location.href='../cad_operacao.php';
		</script>";
	//  echo "Error updating record: " . $mysqli->error;  // DEUBUG
	}
	
	
	$mysqli->close(); // fecha a conexao
?>
	