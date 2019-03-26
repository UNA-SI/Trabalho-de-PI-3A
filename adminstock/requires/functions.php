<?php 
// FUNCOES GERAIS
class Functions {
	// Redirecionamento
	function redirect($local){
		header("Location: $local");
		$mysqli->close();
	}
	// Alerta e depois redirecionamento
	function alertaRedirect($mensagem, $local){
		echo "
		<script>
			alert('".$mensagem."');
			window.location.href='".$local."'
		</script>";
		$mysqli->close();
	}
}
?>