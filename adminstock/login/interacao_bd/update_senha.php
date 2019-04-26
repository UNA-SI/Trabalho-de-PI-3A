<?php
	require_once("../../requires/connect.php");   // Conexao com o banco de dados
	require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
	require_once("../../requires/functions.php"); // Funcoes

class TrocarSenha
{
	private $mysqli; // Conexao com o banco de dados
	private $token; // Token para recuperacao de senha
	private $senha; // Senha digitada pelo usuario
	private $novaSenha; // Senha criptografada
	private $novoToken; // Novo token gerado

	// Insere os dados do formulario a classe
	function __construct($mysqli, $token, $senha)
	{
		$this->mysqli = $mysqli; // Conexao com o banco de dados
		$this->token = $token; // Token utilizado pelo usuario
		$this->senha = $senha; // Senha digitada pelo usuario
	}

	public function checaTokenExpirado() // Confere se o token e valido
	{
		$select = $this->mysqli->query("
			SELECT recuperar_senha 
			FROM usuario 
			WHERE recuperar_senha = '{$this->token}'");
		$result = $select->fetch_assoc();
		if (empty($result)){  // Caso nao encontre o token, pede para solocitar um novo token
			Functions::alertaRedirect("Token expirado, solicite a troca de senha novamente!", "../trocar_senha.html");
		}
	}
	public function criptografar() // Criptografa senha digitada e gera novo token
	{
		// criptografa a senha digitada
		$this->novaSenha = Bcrypt::hash($this->senha);
		// Gera novo hash para recuperar senha
		$this->novoToken = Bcrypt::generateRandomHash();
	}
	
	public function atualizarBancoDeDados() // Atualiza os novos dados no banco de dados
	{
		$update = "
			UPDATE usuario 
			SET senha = '{$this->novaSenha}', recuperar_senha = '{$this->novoToken}' 
			WHERE recuperar_senha = '{$this->token}'";
		$this->mysqli->query($update);
		
		if (mysqli_affected_rows($this->mysqli) == 0) { // Caso falhe, informa o usuario e pede para tentar novamente
			Functions::alertaRedirect("Houve um erro, ao realizar a troca da senha, tente novamente!", 
				"../definir_senha.php?zeqe0eZoda28goklt3W0={$this->token}");
		}
		Functions::alertaRedirect("Troca Realizada com sucesso!", "../../../index.html"); // Informa o usuario que a troca foi bem sucedida.
	}
}
$novaSenha = new TrocarSenha($mysqli, $_POST['recuperar_senha'], $_POST['senha']); // Instancia o objeto
$novaSenha->checaTokenExpirado(); // Confere se o token e valido
$novaSenha->criptografar(); // Criptografa senha digitada e gera novo token
$novaSenha->atualizarBancoDeDados(); // Atualiza os novos dados no banco de dados
?>
	