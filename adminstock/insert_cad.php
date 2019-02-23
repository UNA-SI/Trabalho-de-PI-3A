<?php
require_once("connect.php");

// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
$pri_nome = $_POST['pri_nome'];
$ult_nome = $_POST['ult_nome'];
$email = $_POST['email'];
$login = $_POST['login'];
$senha = hash('md5', $_POST['senha']);

// É REALIZADA UMA BUSCA NO BANCO SE A CONTA JÁ EXISTE
$select = $mysqli->query("SELECT login, senha FROM Usuario WHERE login ='$login' AND senha ='$senha'");
$result = $select->fetch_assoc();

// CASO ELA EXISTA, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
if($result != "")
{ 	
		echo "<script>
		alert('Essa conta j\u00e1 existe!');
		window.location.href='register.php';
		</script>";
}

// CASO NÃO EXISTA, OS NOVOS DADOS SÃO INSERIDOS E O USUÁRIO RETORNA A TELA DE LOGIN
else{ 
	$insert = $mysqli->query("INSERT INTO Usuario (login, senha, pri_nome, ult_nome, email) VALUES('$login', '$senha', '$pri_nome','$ult_nome', '$email')");
	$mysqli->query($insert);	
    echo "<script>
	alert('Conta criada com sucesso!');
	window.location.href='../index.php';
	</script>";
}
	
$mysqli->close(); // fecha a conexao
?>
	