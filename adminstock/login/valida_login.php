<?php
session_start();
require_once("../requires/connect.php");

function redirect($local){   // enviar o usuario para a pagina do parametro
	header("Location: $local");
}

$senha = hash('md5', $_POST['senha']);

$select = $mysqli->query("SELECT login, pri_nome, ult_nome FROM Usuario WHERE login ='{$_POST['login']}' AND senha ='$senha'");
$result = $select->fetch_assoc();

// CASO O LOGIN ESTEJA CORRETO, OS DADOS SAO ARMAZENADOS EM UMA VARIAVEL DE SESSÃO
if($select->num_rows != ""){  // checa se o login é valido
	session_start();
	$_SESSION['login'] = $_POST['login'];
	$_SESSION['pri_nome'] = $result['pri_nome'];
	$_SESSION['ult_nome'] = $result['ult_nome'];
	redirect("../main/tables.php");
}else{	
	echo "<script>
			alert('Login ou senha incorretos. Tente Novamente.');
			window.location.href='../../index.html';
		  </script>";
}
$mysqli->close(); // fecha a conexao
?>
