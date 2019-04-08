<?php
	require_once("../../requires/connect.php"); // CONEXAO COM O BD
	require_once("../../requires/functions.php"); // FUNCOES
	ini_set('default_charset', 'UTF-8'); // FAZ O BANCO ACEITAR ACENTUAÇÃO AO INSERIR ** IMPORTANTE **
	mysqli_set_charset($mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
	
	//CLASSE RESPONSAVEL QUE INSERCAO DE NOVOS ITEMS AO BD
	Class CadastrarProduto
	{		
		private $mysqli;
		private $descProd;
		private $codCat;
		
		public function __construct($mysqli, $postDescProd, $postCodCat){
			$this->mysqli = $mysqli;
			$this->descProd = $postDescProd;
			$this->codCat = $postCodCat;
		}	
		
		public function verificaCadastroDuplicado()
		{
			// VERIFICA SE O ITEM JÁ FOI CADASTRADO
			$select = $this->mysqli->query("
			SELECT item_desc 
			FROM item 
			WHERE item_desc = '{$this->descProd}'");
			$result = $select->fetch_assoc();
			if (!empty($result)){
				Functions::alertaRedirect("Produto j\u00e1 cadastrado!", "../cad_produto.php");
			}			
		}

		public function insereItem()
		{
			// INSERE OS DADOS CADASTRADOS NA TABELA DE ITEMS
			$insert = "INSERT INTO item (item_desc, cod_categoria) 
			VALUES('{$this->descProd}','{$this->codCat}')";
			if($this->mysqli->query($insert) === TRUE){ // CASO A INSERCAO SEJA BEM SUCEDIDA, E DADO PROSEGUIMENTO
				self::insereNoEstoque();
			}else{
				Functions::alertaRedirect("N\u00e3o foi poss\u00edvel cadastrar o item, tente novamente!", "../cad_produto.php");
			}
		}
		public function insereNoEstoque()
		{
			// BUSCA OS DADOS RECEM CADASTRADOS
			$select = "
				SELECT id, item_desc, cod_categoria 
				FROM item 
				WHERE item_desc = '{$this->descProd}' 
				AND cod_categoria = '{$this->codCat}'
			";
			$result = $this->mysqli->query($select);
			$row = $result->fetch_assoc();
			if (!empty($result)){
				// INSERE OS DADOS DO ITEM NA TBL ESTOQUE
				$insert = "
					INSERT INTO estoque (cod_item, item_desc, cod_categoria) 
					VALUES('{$row['id']}' ,'{$row['item_desc']}', '{$row['cod_categoria']}')
				";
				if($this->mysqli->query($insert) === FALSE){
					Functions::alertaRedirect("Ocorreu um erro ao cadastrar o produto, tente novamente!", "../cad_produto.php");
				}
			} else {
				Functions::alertaRedirect("Ocorreu um erro ao cadastrar o produto, tente novamente!", "../cad_produto.php");
			}
			Functions::alertaRedirect("Produto cadastrado com sucesso!", "../cad_produto.php");
		} 
	}
	$novoProduto = new CadastrarProduto($mysqli, $_POST['descProd'], $_POST['codCat']);	
	$novoProduto->verificaCadastroDuplicado();
	$novoProduto->insereItem(); 
?>
	