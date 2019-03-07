<?php
	require_once("../../requires/connect.php");
	
	// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
	$desc_prod = $_POST['desc_prod'];
	$cat_prod = $_POST['cat_prod'];

	$insert = "INSERT INTO item (item_desc, cod_categoria) 
	VALUES('$desc_prod' ,'$cat_prod')";
    
	if ($mysqli->query($insert) === TRUE) {
		require_once("insert_estoque.php");
		echo "<script>
		alert('Produto cadastrado com sucesso!');
		window.location.href='../cad_produto.php';
		</script>";
		
	}else{
		echo "<script>
		alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
		window.location.href='../cad_produto.php';
		</script>";
	//  echo "Error updating record: " . $mysqli->error;  // DEUBUG
	}
	
	
	$mysqli->close(); // fecha a conexao
?>
	