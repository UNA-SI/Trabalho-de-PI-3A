<?php 
	require_once("../../requires/connect.php");   // Conexao com o banco de dados
	require_once("../../requires/functions.php"); // Funcoes

class Usuario
{
	private $mysqli; // Conexao com o banco de dados
	private $idUser; // ID do usuario
	private $novaPermissao; // Nova permissao atribuida ao usuario

	function __construct($mysqli, $idUser, $novaPermissao)
	{
		$this->mysqli = $mysqli; // Conexao com o banco de dados
		$this->idUser = $idUser; // Token utilizado pelo usuario
		$this->novaPermissao = $novaPermissao; // Senha digitada pelo usuario
	}

	public function atualizarPermissao() // Atualizar a permissao do usuario no banco
	{
		$update = "
			UPDATE usuario 
			SET permissao='{$this->novaPermissao}'
			WHERE id='$this->idUser'";		
		if ($this->mysqli->query($update) === FALSE) {
			Functions::alertaRedirect("Ocorreu um erro, tente novamente!", "../usuarios.php");
		}
		Functions::alertaRedirect("Permiss\u00e3o alterada com sucesso!", "../usuarios.php");
	}

}		
$usuario = new Usuario($mysqli, $_POST['id'], $_POST['alt_perm']); // Instancia o objeto e passa parametros a classe
$usuario->atualizarPermissao(); // Atualizar a permissao do usuario no banco
?>