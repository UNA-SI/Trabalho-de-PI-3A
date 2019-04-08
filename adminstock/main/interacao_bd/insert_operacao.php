<?php
	require_once("../../requires/connect.php"); // CONEXAO COM O BD
	require_once("../../requires/functions.php"); // FUNCOES
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	
	Class CadastroOperacao
	{		
		private $mysqli;
		private $descOp;
		private $tipoOp;
		
		public function __construct($mysqli, $postDescOp, $postTipoOp){
			$this->mysqli = $mysqli;
			$this->descOp = $postDescOp;
			$this->tipoOp = $postTipoOp;
		}	
		
		public function inseirOperacao()
		{
			$insert = "INSERT INTO operacao (desc_operacao, tipo) 
			VALUES('{$this->descOp}', '{$this->tipoOp}')";
		
			if ($this->mysqli->query($insert) === FALSE) {
				Functions::alertaRedirect("Ocorreu um erro ao cadastrar a Opera\u00e7\u00e3o, tente novamente!", "../cad_operacao.php");
			}
			Functions::alertaRedirect("Opera\u00e7\u00e3o cadastrada com sucesso!", "../cad_operacao.php");
		}	
	}
	$novaOperacao = new CadastroOperacao($mysqli, $_POST['desc_op'], $_POST['tipo_op']);
	$novaOperacao->inseirOperacao();
	
?>
	