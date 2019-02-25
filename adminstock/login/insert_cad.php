<?php
require_once("../requires/connect.php");

function gerarStringAleatoria($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}





// BUSCADO DADOS DO FORMULÁRIO DA PÁGINA DE CADASTRO E ARMAZENA EM NOVAS VARIAVÉIS
$pri_nome = $_POST['pri_nome'];
$ult_nome = $_POST['ult_nome'];
$email = $_POST['email'];
$login = $_POST['login'];
$senha = hash('md5', $_POST['senha']);
$pass_recovery = hash('md5', gerarStringAleatoria()); 
// É REALIZADA UMA BUSCA NO BANCO SE A CONTA JÁ EXISTE
$select = $mysqli->query("SELECT email FROM Usuario WHERE email='$email'");
$result = $select->fetch_assoc();

// CASO ELA EXISTA, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
if($result != "")
{ 	
		echo "<script>
		alert('Esse email j\u00e1 est\u00e1 cadastrado!');
		window.location.href='register.html';
		</script>";
}
// BUSCA NO BANCO SE UM LOGIN E SENHA IDENTICO EXISTE
$select = $mysqli->query("SELECT login, senha FROM Usuario WHERE login = '$login' AND senha = '$senha'");
$result = $select->fetch_assoc();

// CASO ELA EXISTA, O USUÁRIO É INFORMADO E REDIRECIONADO PARA A PÁGINA DE REGISTRO NOVAMENTE
if($result != "")
{ 	
		echo "<script>
		alert('Essa conta j\u00e1 est\u00e1 cadastrada!');
		window.location.href='register.html';
		</script>";
}

// CASO NÃO EXISTA, OS NOVOS DADOS SÃO INSERIDOS E O USUÁRIO RETORNA A TELA DE LOGIN
else{ 
	$insert = $mysqli->query("INSERT INTO Usuario (login, senha, pass_recovery, pri_nome, ult_nome, email) VALUES('$login', '$senha','$pass_recovery', '$pri_nome','$ult_nome', '$email')");
	$mysqli->query($insert);	
    echo "<script>
	alert('Conta criada com sucesso!');
	window.location.href='../../index.html';
	</script>";
}
	
$mysqli->close(); // fecha a conexao
?>
	