<?php 
echo $_POST['cod_item'];
	require_once("../../requires/connect.php");   // Conexao com o banco de dados
	require_once("../../requires/functions.php"); // Funcoes
 // Inicia a sessao
	SESSION_START(); // Inicia a sessao
	
class Movimentacao
{
	private $mysqli; // Conexao com o banco de dados
	private $quantidade; // Quantidade a ser movimentada
	private $codOp; // Cod da operacao utilizada
	private $codItem; // Cod item recebendo a movimentacao
	private $saldo; // Saldo de items no estoque
	private $tipoOp; // Tipo de operacao
	private $descOp; // Descricao da operacao
	private $nome; // Nome do usuario que realizou a operacao

	function __construct($mysqli, $quantidade, $codOp, $codItem)
	{
		$this->mysqli = $mysqli; // Conexao com o banco de dados
		$this->quantidade = $quantidade; // Quantidade a ser movimentada
		$this->codOp = $codOp; // Cod da operacao utilizada
		$this->codItem = $codItem; // Cod item recebendo a movimentacao
		$this->nome = "".$_SESSION['pri_nome']." ".$_SESSION['ult_nome']."";
	}

	public function buscadoSaldoEstoque() // Busca no banco de dados o saldo do item
	{
		$select = "
			SELECT saldo
			FROM estoque 
			WHERE cod_item = '{$this->codItem}'";
		$result = $this->mysqli->query($select);
		if (empty($result)){  // Caso o item nao seja encontrado, e dada uma msg de erro
			Functions::alertaRedirect("Item n\u00e3o encontrado!", "../movnt_estoque.php");
		}
		$row = $result->fetch_assoc();
		$this->saldo = $row['saldo']; // Armazena na variavel da classe o saldo do item
	}
	public function buscaOperacao() // Busca no banco de dados a operacao utilizada
	{
		$select = "
			SELECT tipo, desc_operacao 
			FROM operacao 
			WHERE cod_operacao = '{$this->codOp}'";
		$result = $this->mysqli->query($select);
		if (empty($result)){  // Caso nao encontre a operacao, e dada uma msg de erro
			Functions::alertaRedirect("Opera\u00e7\u00e3o n\u00e3o encontrada!", "../movnt_estoque.php");
		}
		$row = $result->fetch_assoc();
		$this->tipoOp = $row['tipo']; // Armazena na variavel da classe o tipo da operacao
		$this->descOp = $row['desc_operacao']; // Armazena na variavel da classe a desc da operacao
	}

	public function calculaNovoSaldo() // Calcula o novo saldo de acordo com a operacao utilizada
	{
		switch($this->tipoOp){
			case 'E': // Operacao de entrada
				$this->saldo = $this->saldo + $this->quantidade;
				break;
			case 'S': // Operacao de saida
				$this->saldo = $this->saldo - $this->quantidade;
				break;
		}
		if($this->saldo < 0){ // Caso o saldo final seja negativo, e dada uma msg de erro
			Functions::alertaRedirect("N\u00e3o existem produtos suficientes no estoque!", "../movnt_estoque.php");
		}
	}

	public function salvaNoBanco()
	{
		// Salva o log da movimentacao no banco de dados
		$insert = "
			INSERT INTO estoque_movnto (cod_item, cod_operacao, desc_operacao, tipo, qtde, dat_movimento, usuario) 
			VALUES('{$this->codItem}', '{$this->codOp}', '{$this->descOp}', '{$this->tipoOp}', '{$this->quantidade}', NOW(), '{$this->nome}')";
		if ($this->mysqli->query($insert) === FALSE) { // Caso a insercao falhe, uma msg de erro e dada
			Functions::alertaRedirect("Ocorreu um erro ao realizar a movimenta\u00e7\u00e3o, tente novamente!", "../movnt_estoque.php");	
		}
		// Atualiza o novo saldo no estoque
		$update = "
			UPDATE estoque 
			SET saldo='{$this->saldo}' 
			WHERE cod_item = '{$this->codItem}'";
		$this->mysqli->query($update);
		if (mysqli_affected_rows($this->mysqli) == 0) { // Caso falhe, informa o usuario e pede para tentar novamente
			Functions::alertaRedirect("Ocorreu um erro ao realizar a movimenta\u00e7\u00e3o, tente novamente!", "../movnt_estoque.php");
		}
		Functions::alertaRedirect("Movimenta\u00e7\u00e3o realizada com sucesso!", "../movnt_estoque.php");
	}
}
$movimentacao = new Movimentacao($mysqli, $_POST['qtde'], $_POST['cod_op'],  $_POST['cod_item'] ); // Instancia o objeto
$movimentacao->buscadoSaldoEstoque();
$movimentacao->buscaOperacao();
$movimentacao->calculaNovoSaldo();
$movimentacao->salvaNoBanco();
?>