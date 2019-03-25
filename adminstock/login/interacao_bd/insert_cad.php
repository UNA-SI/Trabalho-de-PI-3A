<?php
require_once("../../requires/connect.php");
require_once("../../requires/bcrypt.php");
require_once("../../requires/functions.php");

$select = $mysqli->query("SELECT email FROM usuario WHERE email='{$_POST['email']}'");
$result = $select->fetch_assoc();

if (!empty($result)){ // CASO O EMAIL JA EXISTE, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
	alertaRedirect("Esse email j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
}

$select = $mysqli->query("SELECT login FROM usuario WHERE login='{$_POST['login']}'");
$result = $select->fetch_assoc();

if (!empty($result)){ // CASO O LOGIN JA EXISTE, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
	alertaRedirect("Esse login j\u00e1 est\u00e1 cadastrado!", "../registrar.html");
}

// gera um hash aleatorio para recuperar a senha
$pass_recovery = Bcrypt::generateRandomSalt();
$hash_recovery = Bcrypt::hash($pass_recovery);

// criptografa a senha digitada
$senha = $_POST['senha'];
$hash_senha = Bcrypt::hash($senha);

$insert = "
	INSERT INTO usuario 
	(login, senha, recuperar_senha, pri_nome, ult_nome, email) 
	VALUES('{$_POST['login']}', '$hash_senha', '$hash_recovery', '{$_POST['pri_nome']}', '{$_POST['ult_nome']}', '{$_POST['email']}')
	";

if ($mysqli->query($insert) === TRUE) {
	alertaRedirect("Conta criada com sucesso!", "../../../index.html");
} else {
	alertaRedirect("Erro ao criar conta, tente novamente!", "../registrar.html");
}
?>