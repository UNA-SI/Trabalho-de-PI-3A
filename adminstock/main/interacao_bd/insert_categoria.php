<?php
	require_once("../../requires/connect.php");
	
	// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
	$desc_cat = $_POST['desc_cat'];

	// É REALIZADA UMA BUSCA NO BANCO SE A CATEGORIA JÁ EXISTE
	$select = $mysqli->query("SELECT desc_categoria FROM categoria WHERE desc_categoria='$desc_cat'");
	$result = $select->fetch_assoc();
	
	
	// CASO ELA EXISTA, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
	if($result != "")
	{ 	
		echo "<script>
			alert('Essa categoria j\u00e1 est\u00e1 cadastrada!');
			window.location.href='../cad_categoria.php';
			</script>";
	}else{
		$insert = "INSERT INTO categoria (desc_categoria) 
		VALUES('$desc_cat')";
		
		if ($mysqli->query($insert) === TRUE) {
			echo "<script>
			alert('Categoria cadastrada com sucesso!');
			window.location.href='../cad_categoria.php';
			</script>";
		}else{
			echo "<script>
			alert('Ocorreu um erro ao cadastrar a categoria, tente novamente!');
			window.location.href='../cad_categoria.php';
			</script>";
		//  echo "Error updating record: " . $mysqli->error;  // DEUBUG
		}
	}
	
	$mysqli->close(); // fecha a conexao
?>
	