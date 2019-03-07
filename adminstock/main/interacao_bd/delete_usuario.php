<?php 
	require_once("../../requires/connect.php");
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	$id = $_GET['BoK2sW7fUfiDLs5Zugof'];
	
	$delete = "DELETE FROM usuario WHERE id='$id'";

	if ($mysqli->query($delete) === TRUE) {
		echo "<script>
		alert('usu\u00e1rio deletado com sucesso!');
		window.location.href='../usuarios.php';
		</script>";
	} else {
		echo "<script>
		alert('Ocorreu um erro, tente novamente!');
		window.location.href='../usuarios.php';
		</script>";
		// echo "Error updating record: " . $mysqli->error; DEBUG
	}
 
$mysqli->close();
?>