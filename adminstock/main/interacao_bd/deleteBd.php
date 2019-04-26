<?php 

	require_once("../../requires/connect.php"); // Conexao com o banco de dados
	require_once("../../requires/functions.php"); // Funcoes
	class deletaDados
	{
		private $mysqli; // Conexao com o banco de dados
		private $id; // Id do usuario
		function __construct($mysqli, $id) // Construtor
		{		
			$this->mysqli = $mysqli; // Conexao com o banco de dados
			$this->id = $id; // Id do usuario
		}

		public function deletarUsuario() // Deleta o usuario pelo ID
		{
			$delete = "DELETE FROM usuario WHERE id ='{$this->id}'";

			if ($this->mysqli->query($delete) === FALSE) { // Confere se o delete foi bem sucedido
				Functions::alertaRedirect("Ocorreu um erro, tente novamente!", "../usuarios.php");
			}
			Functions::alertaRedirect("Usu\u00e1rio deletado com sucesso!", "../usuarios.php");			
		}

		// Deleta o produto da tabela item e estoque e salva um log da operacao
		public function deletarProduto($mysqli, $itemDesc, $codItem, $codOp, $descOp, $tipoOp, $nome) 
		{
			$delete = "DELETE FROM estoque WHERE cod_item ='{$codItem}'";
			if ($mysqli->query($delete) === FALSE) { // Confere se o delete foi bem sucedido
				Functions::alertaRedirect("Ocorreu um erro, tente novamente!", "../movnt_estoque.php");
			} 

			$delete = "DELETE FROM item WHERE id ='{$codItem}'";
			if ($mysqli->query($delete) === FALSE) { // Confere se o delete foi bem sucedido
				Functions::alertaRedirect("Ocorreu um erro, tente novamente!", "../movnt_estoque.php");
			} 

			// Salva um log do produto deletado
			$insert = "
				INSERT INTO estoque_movnto (item_desc, cod_item, cod_operacao, desc_operacao, tipo, qtde, dat_movimento, usuario) 
				VALUES('{$itemDesc}' ,'{$codItem}', '{$codOp}', '{$descOp}', '{$tipoOp}', '-', NOW(), '{$nome}')";	
			if ($mysqli->query($insert) === FALSE) { // Caso a insercao falhe, uma msg de erro e dada
				Functions::alertaRedirect("Ocorreu um erro ao realizar a movimenta\u00e7\u00e3o, tente novamente!", "../movnt_estoque.php");	
			}
			Functions::alertaRedirect("O item foi deletado com sucesso!", "../movnt_estoque.php");
		}
	}
	$delete = new deletaDados($mysqli, $_GET['BoK2sW7fUfiDLs5Zugof']);
	if($_GET['BoK2sW7fUfiDLs5Zugof'] != NULL){ // Caso o GET possua valor, o metodo deletarUsuario e chamado
		$delete->deletarUsuario();
	}
?>