<?php
require_once("../../requires/connect.php");   // Conexao com o banco de dados
require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
require_once("../../requires/functions.php"); // Funcoes
// Busca se o email ja esta cadastrado
$select = $mysqli->query("SELECT email FROM usuario WHERE email='{$_POST['email']}'");
$result = $select->fetch_assoc();
if (!empty($result)){ // Caso esteja, imprime mensagem de erro e redirecionamento
	Functions::alertaRedirect("Esse email j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
}
// Busca se o login ja esta cadastrado
$select = $mysqli->query("SELECT login FROM usuario WHERE login='{$_POST['login']}'");
$result = $select->fetch_assoc();
if (!empty($result)){ // Caso esteja, imprime mensagem de erro e redirecionamento
	Functions::alertaRedirect("Esse login j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
}

// gera um hash aleatorio para recuperar a senha
$pass_rec = Bcrypt::generateRandomHash();
// criptografa a senha digitada
$hash_pass = Bcrypt::hash($_POST['senha']);
// Insere os dados do usuario no bd
$insert = "	INSERT INTO usuario (login, senha, recuperar_senha, pri_nome, ult_nome, email) 
			VALUES('{$_POST['login']}', '$hash_pass', '$pass_rec', '{$_POST['pri_nome']}', '{$_POST['ult_nome']}', '{$_POST['email']}')";
if ($mysqli->query($insert) === TRUE) { // Caso a insercao seja bem sucedidade, o usuario e informado
	Functions::alertaRedirect("Conta criada com sucesso!", "../../../index.html");
} 
Functions::alertaRedirect("Erro ao criar conta, tente novamente!", "../registrar.html"); // caso ocorra um erro na insersao, o usuario e informado
?>