<?php
require_once("connect.php");

function redirect($local){   // enviar o usuario para a pagina do parametro
	header("Location: $local");
}

echo $_POST['pri_nome'];
echo $_POST['ult_nome'];
echo $_POST['login'];
echo $_POST['senha'];
echo $_POST['conf_senha'];

$senha = hash('md5', $_POST['senha']);


$select = $mysqli->query("SELECT login, senha, pri_nome, ult_nome FROM Usuario WHERE login ='{$_POST['nome']}' AND senha ='{$senha}'");
$result = $select->fetch_assoc();

if(!$result)
{
	redirect("register.php");
	echo "<script type='text/javascript'>alert('Essa conta já existe!')</script>";
}
else{
	$insert = $mysqli->query("INSERT INTO Usuario (login, senha, pri_nome, ult_nome");
	$mysqli->query($insert);
	
	
	redirect(".../index.php");
	echo "<script type='text/javascript'>alert('Conta criada com sucesso!')</script>";
}
$mysqli->close(); // fecha a conecxão */
?>
