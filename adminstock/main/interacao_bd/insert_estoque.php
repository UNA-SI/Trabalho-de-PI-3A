<?php
	require_once("../../requires/connect.php");
	
	$select = "SELECT id, item_desc, cod_categoria FROM item WHERE item_desc = '$desc_prod' AND cod_categoria = '$cat_prod'";
	$result = $mysqli->query($select);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();		
		$insert = "INSERT INTO estoque (cod_item, item_desc, cod_categoria) 
		VALUES('{$row['id']}' ,'{$row['item_desc']}', '{$row['cod_categoria']}')";
		
		if ($mysqli->query($insert) === FALSE) {
			echo "<script>
			alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
			window.location.href='../cad_produto.php';
			</script>";
			echo "Error updating record: " . $mysqli->error;  // DEUBUG
		}
	} else {
		echo "<script>
		alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
		window.location.href='../cad_produto.php';
		</script>";
	}
	$mysqli->close(); // fecha a conexao
?>
	