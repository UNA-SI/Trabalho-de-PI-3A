<?php
	require_once("../../requires/connect.php"); // CONEXAO COM O BD
	require_once("../../requires/functions.php"); // FUNCOES
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	Class CadastrarCategoria
	{
		private $mysqli; // Conexao com o banco de dados
		private $descCat; // Descricao da categoria
		
		public function __construct($mysqli, $postDescCat){ // Construtor
			// Passa o valor do parametro para a variavel da classe
			$this->mysqli = $mysqli; 
			$this->descCat = $postDescCat;
		}	
		
		function verificaCadastroDuplicado() // Busca se existe categoria duplicada
		{
			// Uma busca e realizada para verificar se a dscricao da categoria ja foi utilizada
			$select = $this->mysqli->query("
				SELECT desc_categoria 
				FROM categoria 
				WHERE desc_categoria='{$this->descCat}'");
			$result = $select->fetch_assoc();
			 // Caso a busca encontre um valor duplicado, o codigo para de executar e uma mensagem de erro e apresentada
			if (!empty($result)){ 
				Functions::alertaRedirect("Categoria j\u00e1 cadastrada!", "../cad_categoria.php");
			}	
		}
	
		function insereCategoria() // Insere a categoria no banco de dados
		{
			// E realizada uma insercao no banco de dados da nova categoria selecionada
			$insert = "INSERT INTO categoria (desc_categoria) 
			VALUES('{$this->descCat}')";
			 // Caso a insercao falhe, o codigo para de executar e uma mensagem de erro e apresentada
			if($this->mysqli->query($insert) === FALSE){
				Functions::alertaRedirect("Ocorreu um erro ao cadastrar a categoria, tente novamente!", "../cad_categoria.php");
			}
			// Caso a insercao seja bem sucedida, uma mensagem de sucesso e dada e apos o usuario e redirecionado
			Functions::alertaRedirect("Categoria cadastrada com sucesso!", "../cad_categoria.php");
		}
	}
$novaCategoria = new CadastrarCategoria($mysqli, $_POST['desc_cat']); // Um novo objeto e criado e os parametro sao enviados ao construtor
$novaCategoria->verificaCadastroDuplicado(); // Busca se a categoria ja esta cadastrada
$novaCategoria->insereCategoria();  // Insere a categoria no banco de dados
?>