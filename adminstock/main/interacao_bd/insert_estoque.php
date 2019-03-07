<?php
	require_once("../../requires/connect.php");
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	// É REALIZADA UMA BUSCA DOS DADOS RECEM INSERIDOS NA TABELA ITEM
	$select = "SELECT id, item_desc, cod_categoria FROM item WHERE item_desc = '$desc_prod' AND cod_categoria = '{$row['cod_categoria']}'";
	$result = $mysqli->query($select);
	
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		// É REALIZADA UMA INSERÇÃO NA TABELA ESTOQUE DO ITEM INSERIDO
		$insert = "INSERT INTO estoque (cod_item, item_desc, cod_categoria) 
		VALUES('{$row['id']}' ,'{$row['item_desc']}', '{$row['cod_categoria']}')";
		
		if ($mysqli->query($insert) === FALSE) { // CASO NÃO SEJA POSSÍVEL INSERIR NA TABELA ESTOQUE, É MOSTRADA UMA MENSAGEM DE ERRO
			echo "<script>
			alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
			window.location.href='../cad_produto.php';
			</script>";
		//	echo "Error updating record: " . $mysqli->error;  // DEUBUG
		}
	} else { // CASO O ITEM CADASTRADO NÃO SEJA ENCONTRADO, É MOSTRADA UMA MENSAGEM DE ERRO
		echo "<script>
		alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
		window.location.href='../cad_produto.php';
		</script>";
	}
	$mysqli->close(); // fecha a conexao
?>
	