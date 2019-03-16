<?php 
	require_once("../../requires/connect.php");
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	session_start();
	
	$qtde = $_POST['qtde'];
	$cod_op = $_POST['cod_op'];
	$item_desc = $_POST['item_desc'];
	
	// BUSCA DADOS DA TABELA ESTOQUE
	$select_es = "SELECT saldo, cod_item FROM estoque WHERE item_desc = '$item_desc'";
	$result_es = $mysqli->query($select_es);
	$row_es = $result_es->fetch_assoc();

	// BUSCA DADOS DA TABELA OPERAÇÃO
	$select_op = "SELECT tipo, desc_operacao FROM operacao WHERE cod_operacao = '$cod_op'";
	$result_op = $mysqli->query($select_op);
	$row_op = $result_op->fetch_assoc();
			
	// REALIZA A ADIÇÃO OU SUBTRAÇÃO DE PRODUTOS NO ESTOQUE		
	switch($row_op['tipo']){
		case 'E':
			$saldo = $row_es['saldo'];
			$novo_saldo = $saldo + $qtde;
			break;
		case 'S':
			$saldo = $row_es['saldo'];
			$novo_saldo = $saldo - $qtde;
			break;
	}
	// CASO O SALDO FINAL SEJA MENOR QUE 0, O PROGRAMA É PARADO E É MOSTRADA UMA MENSAGEM DE ERRO
	if($novo_saldo < 0){
		echo "<script>
		alert('N\u00e3o existem produtos suficientes no estoque!');
		window.location.href='../movnt_estoque.php';
		</script>";
	}
	// CASO O SALDO FINAL SEJA MAIOR QUE 0, É REALIZADO UM INSERT E UPDATE NAS TABELAS ESTOQUE_MOVNT E ESTOQUE RESPECTIVAMENTE
	else
	{
		$dat_atual = date("Y-m-d H:i:s");  
		$nome = "".$_SESSION['pri_nome']." ".$_SESSION['ult_nome']."";
		
		$insert = "INSERT INTO estoque_movnto (cod_item, cod_operacao, desc_operacao, tipo, qtde, dat_movimento, usuario) 
		VALUES('{$row_es['cod_item']}', '$cod_op', '{$row_op['desc_operacao']}', '{$row_op['tipo']}', '$qtde', '$dat_atual', '$nome')";		
		
		$update = "UPDATE estoque SET saldo='$novo_saldo' WHERE cod_item = '{$row_es['cod_item']}'";
		// CASO AS DUAS INTERAÇÕES COM O BANCO DE DADOS SEJAM BEM SUCEDIDAS, O PROGRAMA É FINALIZADO E É EXIBIDA UMA MSG DE SUCESSO
		if ($mysqli->query($insert) === TRUE && $mysqli->query($update) === TRUE) {
			echo "<script>
			alert('Movimenta\u00e7\u00e3o realizada com sucesso!');
			window.location.href='../movnt_estoque.php';
			</script>";
		// CASO ALGUMA DAS INTERAÇÕES COM O BANCO FALHEM, É MOSTRADA UMA MENSAGEM DE ERRO AO USUÁRIO
		}else{
			echo "<script>
			alert('Ocorreu um erro ao realizar a movimenta\u00e7\u00e3o, tente novamente!');
			window.location.href='../movnt_estoque.php';
			</script>";
		}			
	}
$mysqli->close(); // FECHA A CONEXÃO COM O BANCO DE DADOS
?>