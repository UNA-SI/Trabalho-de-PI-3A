<?php
require_once("../../requires/connect.php");   // Conexao com o banco de dados
require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
require_once("../../requires/functions.php"); // Funcoes
// Busca de dados do usuario no bd
$select = $mysqli->query("SELECT login, pri_nome, ult_nome, permissao, senha FROM usuario WHERE login ='{$_POST['login']}'");
$result = $select->fetch_assoc();
// Se a busca retornar vazia, e impressa uma mensagem de erro e redirecionamento
if(empty($result)){	
	alertaRedirect("Usu\u00e1rio incorreto ou n\u00e3o cadastrado!", "../../../index.html");	
}
// Valida se a senha recebida esta correta
if (Bcrypt::check($_POST['senha'], $result['senha'])){
	session_start();                                 // Inicia sessao e armazena dados do usuario 
	$_SESSION['login'] = $_POST['login'];            // em variaveis de ssesao, apos redireciona o usuario
	$_SESSION['pri_nome'] = $result['pri_nome'];	 	
	$_SESSION['ult_nome'] = $result['ult_nome'];
	$_SESSION['permissao'] = $result['permissao'];
	redirect("../../main/consulta_estoque.php");
} else { // caso a senha esteja incorreta, e impressa uma mensagem do erro e o usuario e redirecionado
	alertaRedirect("Login ou senha incorretos. Tente Novamente.", "../../../index.html");
}
?>