<?php 
// FUNCOES GERAIS
class Functions {

	private $mysqli;

	function __construct($mysqli) 
	{
		// Conexao com o banco de dados
		$this->mysqli = $mysqli;
	}
	// Redirecionamento
	function redirect($local)
	{
		header("Location: $local");
		$this->mysqli->close();
	}
	// Alerta e depois redirecionamento
	function alertaRedirect($mensagem, $local)
	{
		echo "
		<script>
			alert('".$mensagem."');
			window.location.href='".$local."'
		</script>";
		$this->mysqli->close();
	}

	public function checaLogin($login, $permissao, $permissaoPagina)
	{
		if(empty($login) or empty($permissao)){
			
		}
		if($permissao > $permissaoPagina){
			self::alertaRedirect('Voc\u00ea n\u00e3o tem permiss\u00e3o para acessar essa p\u00e1gina!', '../../index.html');
		}
	}
}
?>