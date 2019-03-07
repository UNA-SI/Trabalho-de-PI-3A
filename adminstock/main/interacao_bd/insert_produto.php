<?php
	require_once("../../requires/connect.php");
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
	$desc_prod = $_POST['desc_prod'];
	$cat_desc = $_POST['cat_desc'];
	
	
	// VERIFICA SE O ITEM JÁ FOI CADASTRADO
	$select = "SELECT item_desc FROM item WHERE item_desc = '$desc_prod'";
	$result = $mysqli->query($select);
	
	if ($result->num_rows == "") {	
		
		// BUSCA O ID DO ITEM A PARTIR DA DESCRIÇÃO
		$select = "SELECT cod_categoria FROM categoria WHERE desc_categoria = '$cat_desc'";
		$result = $mysqli->query($select);

		
		if ($result->num_rows > 0) { 
		
			$row = $result->fetch_assoc();
			// INSERE OS DADOS CADASTRADOS NA TABELA DE ITEMS
			$insert = "INSERT INTO item (item_desc, cod_categoria) 
			VALUES('{$desc_prod}' ,'{$row['cod_categoria']}')";
			
			if ($mysqli->query($insert) === TRUE) { 
			// QUANDO A INSERÇÃO É EXECUTADA COM SUCESSO, É CHAMADA A PÁGINA PARA O INSERT NA TABELA ESTOQUE, CASO TAMBÉM DE CERTO É MOSTRADA UMA MENSAGEM DE SUCESSO
				require_once("insert_estoque.php"); 
				echo "<script>
				alert('Produto cadastrado com sucesso!');
				window.location.href='../cad_produto.php';
				</script>";
				
			}else{ // CASO ACONTEÇA UM ERRO AO CADASTRAR O ITEM, É MOSTRADA UMA MENSAGEM DE ERRO
				echo "<script>
				alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
				window.location.href='../cad_produto.php';
				</script>";
			
			//  echo "Error updating record: " . $mysqli->error;  // DEUBUG
			}

		}else{ // CASO NÃO SEJA POSSIVEL ENCONTRAR O ID, É MOSTRADA UMA MENSAGEM DE ERRO
			echo "<script>
			alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
			window.location.href='../cad_produto.php';
			</script>";
		}
	}else{ // CASO O ITEM JÁ TENHA SIDO CADASTRADO, É MOSTRADA UMA MENSAGEM DE ERRO
		
		echo "<script>
		alert('Produto j\u00e1 cadastrado!');
		window.location.href='../cad_produto.php';
		</script>";
	}
	$mysqli->close(); // fecha a conexao
?>
	