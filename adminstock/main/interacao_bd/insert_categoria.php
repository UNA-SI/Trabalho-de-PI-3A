<?php
	require_once("../../requires/connect.php"); // CONEXAO COM O BD
	require_once("../../requires/functions.php"); // FUNCOES
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	Class CadastrarCategoria
	{
		private $mysqli;
		private $descCat;
		
		public function __construct($mysqli, $postDescCat){
			$this->mysqli = $mysqli;
			$this->descCat = $postDescCat;
		}	
		
		function verificaCadastroDuplicado()
		{
			// É REALIZADA UMA BUSCA NO BANCO SE A CATEGORIA JÁ EXISTE
			$select = $this->mysqli->query("
				SELECT desc_categoria 
				FROM categoria 
				WHERE desc_categoria='{$this->descCat}'");
			$result = $select->fetch_assoc();
			if (!empty($result)){ // CASO ESTEJA VAZIO, IMPRIME MENSAGEM DE ERRO E REDIRECIONAMENTO
				Functions::alertaRedirect("Categoria j\u00e1 cadastrada!", "../cad_categoria.php");
			}	
		}
	
		function insereCategoria()
		{
			$insert = "INSERT INTO categoria (desc_categoria) 
			VALUES('{$this->descCat}')";
			if($this->mysqli->query($insert) === FALSE){
				Functions::alertaRedirect("Ocorreu um erro ao cadastrar a categoria, tente novamente!", "../cad_categoria.php");
			}
			Functions::alertaRedirect("Categoria cadastrada com sucesso!", "../cad_categoria.php");
		}
	}

$novaCategoria = new CadastrarCategoria($mysqli, $_POST['desc_cat']);	
$novaCategoria->verificaCadastroDuplicado();
$novaCategoria->insereCategoria(); 
?>