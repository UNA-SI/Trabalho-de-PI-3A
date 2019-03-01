<?php 
	require_once("../../requires/connect.php");
	
	$id = $_POST['id'];
	$perm = $_POST['alt_perm'];
	
	
	$update = "UPDATE usuario SET permissao='$perm' WHERE id='$id'";

	if ($mysqli->query($update) === TRUE) {
		echo "<script>
		alert('Permiss\u00e3o alterada com sucesso!');
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