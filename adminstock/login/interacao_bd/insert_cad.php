d<?php
	require_once("../../requires/connect.php");   // Conexao com o banco de dados
	require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
	require_once("../../requires/functions.php"); // Funcoes	

	class Cadastro{	
		private $token; // Token para recuperar Senha
		private $hashSenha; // Senha criptografada
		private $email; // Email inserido no formulario
		private $login; // Login inserido no formulario
		private $senha; // Senha inserida no formulario
		private $pnome; // Primeiro nome inserido no formulario
		private $unome; // Ultimo nome inserido no formulario
		private $mysqli; // Conexao com o banco de dados
		
		// Insere os dados cadastrados no formulario a classe
		public function __construct($mysqli, $postEmail, $postLogin, $postSenha, $postPnome, $postUnome) {
			$this->mysqli = $mysqli;
			$this->email = $postEmail;
			$this->login = $postLogin;
			$this->senha = $postSenha;
			$this->pnome = $postPnome;
			$this->unome = $postUnome;
		}
		// Verifica se o Email ja foi cadastrado
		public function verificarEmail(){
			// Busca se o email ja esta cadastrado
			$select = $this->mysqli->query("SELECT email FROM usuario WHERE email='{$this->email}'");
			$result = $select->fetch_assoc();

			// Caso esteja duplicado, imprime mensagem de erro e redirecionamento
			if (!empty($result)){ 
				Functions::alertaRedirect("Esse email j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
			}
		}
		// Verifica se o login ja foi cadastrado
		public function verificarLogin(){
			// Busca login do formulario no banco para encontrar duplicado
			$select = $this->mysqli->query("SELECT login FROM usuario WHERE login='{$this->login}'");
			$result = $select->fetch_assoc();

			// Caso esteja duplicado, imprime mensagem de erro e redirecionamento
			if (!empty($result)){ 
				Functions::alertaRedirect("Esse login j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
			}
		}
		// Criptografa a senha e gera um novo hash para recuperar senha
		public function criptografar(){
			// gera um hash aleatorio para recuperar a senhad
			$this->token = Bcrypt::generateRandomHash();
			
			// criptografa a senha digitada
			$this->hashSenha = Bcrypt::hash($this->senha);
		}
		// Salva as alteracoes no banco de dados
		public function salvarNoBanco(){
			// Insere os dados do usuario no bd
			$insert = "	INSERT INTO usuario (login, senha, recuperar_senha, pri_nome, ult_nome, email) 
						VALUES('{$this->login}', '{$this->hashSenha}', '{$this->token}', 
						'{$this->pnome}', '{$this->unome}', '{$this->email}')";
			
			if ($this->mysqli->query($insert) === TRUE) { // Caso a insercao seja bem sucedidade, o usuario e informado
				Functions::alertaRedirect("Conta criada com sucesso!", "../../../index.html");
			} 
			// Caso a operacao nao seja bem sucedidade, uma mensagem de erro e apresentada
			Functions::alertaRedirect("Erro ao criar conta, tente novamente!", "../registrar.html"); 
		}
	}
	// Cria objeto e passa os parametro para o construtor.
	$novoUsuario = new Cadastro($mysqli, $_POST['email'], $_POST['login'],
	 $_POST['senha'], $_POST['pri_nome'], $_POST['ult_nome']);	

	$novoUsuario->verificarEmail();  // Verificar se o email já foi cadastrado
	$novoUsuario->verificarLogin(); // Verificar se o login já foi cadastrado
	$novoUsuario->criptografar(); // Criptografa a senha inserida no formulario e gera novo token
	$novoUsuario->salvarNoBanco();  // Salva o novo cadastro no banco de dados
?>