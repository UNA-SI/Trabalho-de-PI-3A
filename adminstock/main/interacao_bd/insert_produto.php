<?php
require_once("../../requires/connect.php");
// A ORDEM DOS COMANDOS É IMPORTANTE PARA O CORRETO FUNCIONAMENTO
ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**


// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
$cod_prod = $_POST['cod_prod'];
$nom_prod = $_POST['nom_prod'];
$cat_prod = $_POST['cat_prod'];
$cod_forn = $_POST['cod_forn'];
$val_pag  = $_POST['val_pag'];
$val_vend = $_POST['val_vend'];
$qtd_prod = $_POST['qtd_prod'];


	$insert = "INSERT INTO Produto (`Codigo Produto`, `Nome Produto`, `Categoria Produto`, `Codigo Fornecedor`, `Valor Pago`, `Valor Venda`, `Quantidade Produto`) 
	VALUES('$cod_prod' ,'$nom_prod', '$cat_prod', '$cod_forn', '$val_pag', '$val_vend', '$qtd_prod')";
    if ($mysqli->query($insert) === TRUE) {
	echo "<script>
	alert('Dados inseridos com sucesso!');
	window.location.href='../cad_produto.php';
	</script>";
	}else{
		echo "<script>
		alert('Ocorreu um erro ao cadastrar o produto, tente novamente!');
		window.location.href='../cad_produto.php';
		</script>";
	//	echo "Error updating record: " . $mysqli->error;
	}
	
	
$mysqli->close(); // fecha a conexao
?>
	