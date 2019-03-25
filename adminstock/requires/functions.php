<?php 
function redirect($local){
	header("Location: $local");
	$mysqli->close();
}
function alertaRedirect($mensagem, $local){
	echo "
	<script>
		alert('".$mensagem."');
		window.location.href='".$local."'
	</script>";
	$mysqli->close();
}
?>