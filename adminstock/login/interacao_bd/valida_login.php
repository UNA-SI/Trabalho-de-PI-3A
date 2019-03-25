<?php
require_once("../../requires/connect.php");
require_once("../../requires/bcrypt.php");
require_once("../../requires/functions.php");

$select = $mysqli->query("SELECT login, pri_nome, ult_nome, permissao, senha FROM usuario WHERE login ='{$_POST['login']}'");
$result = $select->fetch_assoc();

if(empty($result)){	
	alertaRedirect("Usu\u00e1rio incorreto ou n\u00e3o cadastrado!", "../../../index.html");	
}

// Recebe senha do formulário
$senha = $_POST['senha'];
// armazena a senha do banco na variavél hash
$hash = $result['senha'];

// verifica se as senhas são identicas
if (Bcrypt::check($senha, $hash)){
	// CASO O LOGIN ESTEJA CORRETO, OS DADOS SAO ARMAZENADOS EM UMA VARIAVEL DE SESSÃO
	session_start();
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['pri_nome'] = $result['pri_nome'];
	$_SESSION['ult_nome'] = $result['ult_nome'];
	$_SESSION['permissao'] = $result['permissao'];
	redirect("../../main/consulta_estoque.php");
} else {
	alertaRedirect("Login ou senha incorretos. Tente Novamente.", "../../../index.html");
}
?>
