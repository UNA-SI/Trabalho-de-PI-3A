<?php
require_once("connect.php");

$pri_nome = $_POST['pri_nome'];
$ult_nome = $_POST['ult_nome'];
$login = $_POST['login'];
$senha = hash('md5', $_POST['senha']);


$select = $mysqli->query("SELECT login, senha FROM Usuario WHERE login ='$login' AND senha ='$senha'");
$result = $select->fetch_assoc();

if($result != "")
{ 	
		echo "<script>
		alert('Essa conta j\u00e1 existe!');
		window.location.href='register.php';
		</script>";
}
else{ 
	$insert = $mysqli->query("INSERT INTO Usuario (login, senha) VALUES('$login', '$senha')");
	$mysqli->query($insert);	
    echo "<script>
	alert('Conta criada com sucesso!');
	window.location.href='../index.php';
	</script>";
}
	
$mysqli->close(); // fecha a conecxÃ£o */
?>
	