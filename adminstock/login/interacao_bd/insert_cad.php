<?php
	require_once("../../requires/connect.php");   // Conexao com o banco de dados
	require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
	require_once("../../requires/functions.php"); // Funcoes	

	class Cadastro{	
		public $pass_rec;
		public $hash_pass;
		public $email;
		public $login;
		public $pnome;
		public $unome;
		private $mysqli;

		public function __construct($mysqli, $postEmail, $postLogin, $PostPnome, $postUnome) {
			$this->mysqli = $mysqli;
			$this->email = $postEmail;
			$this->login = $postLogin;
			$this->pnome = $postPnome;
			$this->unome = $postUnome;
		}
		
		public function verificarEmail(){
			// Busca se o email ja esta cadastrado
			$select = $this->mysqli->query("SELECT email FROM usuario WHERE email='".$this->email."'");
			$result = $select->fetch_assoc();
			if (!empty($result)){ // Caso esteja, imprime mensagem de erro e redirecionamento
				Functions::alertaRedirect("Esse email j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
			} 
		}
		public function verificarLogin(){
			// Busca se o login ja esta cadastrado
			$select = $this->mysqli->query("SELECT login FROM usuario WHERE login='{$this->login}'");
			$result = $select->fetch_assoc();
			if (!empty($result)){ // Caso esteja, imprime mensagem de erro e redirecionamento
				Functions::alertaRedirect("Esse login j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
			}
		}
		public function criptografar(){
			// gera um hash aleatorio para recuperar a senha
			$this->pass_rec = Bcrypt::generateRandomHash();
			// criptografa a senha digitada
			$this->hash_pass = Bcrypt::hash($_POST['senha']);
		}
		public function salvarNoBanco(){
			// Insere os dados do usuario no bd
			$insert = "	INSERT INTO usuario (login, senha, recuperar_senha, pri_nome, ult_nome, email) 
						VALUES('{$this->login}', '{$this->hash_pass}', '{$this->pass_rec}', '{$this->pnome}', '{$this->unome}', '{$this->email}')";
			if ($this->mysqli->query($insert) === TRUE) { // Caso a insercao seja bem sucedidade, o usuario e informado
				Functions::alertaRedirect("Conta criada com sucesso!", "../../../index.html");
			} 
			Functions::alertaRedirect("Erro ao criar conta, tente novamente!", "../registrar.html"); // caso ocorra um erro na insersao, o usuario e informado 
		}
	}
	
	$novoUsuario = new Cadastro($mysqli, $_POST['email'], $_POST['login'], $_POST['pri_nome'], $_POST['ult_nome']);
	$novoUsuario->verificarEmail();
	$novoUsuario->verificarLogin();
	$novoUsuario->criptografar();
	$novoUsuario->salvarNoBanco();
	
?>