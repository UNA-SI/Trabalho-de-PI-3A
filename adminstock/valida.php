<?php
require_once("connect.php");

function redirect($local){   // enviar o usuario para a pagina do parametro
	header("Location: $local");
}

$senha = hash('md5', $_POST['senha']);

$select = $mysqli->query("SELECT login, senha FROM Usuario WHERE login ='{$_POST['login']}' AND senha ='$senha'");
$result = $select->fetch_assoc();

// CASO O LOGIN ESTEJA CORRETO, OS DADOS SAO ARMAZENADOS EM UMA VARIAVEL DE SESSÃO
if($select->num_rows === 1){  // checa se o login é valido
	session_start();
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['senha'] = $senha;
	redirect("tables.php");
}else{	
	echo "<script>
			alert('Login ou senha incorretos. Tente Novamente.');
			window.location.href='../index.html';
		  </script>";
}
$mysqli->close(); // fecha a conexao
?>
