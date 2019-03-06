<?php
	require_once("../../requires/connect.php");
	
	// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
	$desc_cat = $_POST['desc_cat'];

	$insert = "INSERT INTO categoria (desc_categoria) 
	VALUES('$desc_cat')";
    
	if ($mysqli->query($insert) === TRUE) {
		echo "<script>
		alert('Categoria cadastrada com sucesso!');
		window.location.href='../cad_produto.php';
		</script>";
	}else{
		echo "<script>
		alert('Ocorreu um erro ao cadastrar a categoria, tente novamente!');
		window.location.href='../cad_produto.php';
		</script>";
	//  echo "Error updating record: " . $mysqli->error;  // DEUBUG
	}
	
	
	$mysqli->close(); // fecha a conexao
?>
	