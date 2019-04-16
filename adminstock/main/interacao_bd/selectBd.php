<?php
	mysqli_set_charset($mysqli, 'utf8'); // Permite imprimir dados com acentuacao na pagina

	class BuscaDados
	{
		private $mysqli; // Conexao com o banco
		private $estoque = ""; // Dados do estoque
		private $hist_mov = ""; // Dados historico de movimentacao
		private $movimentacao = ""; // Dados movimentacao de estoque
		private $operacao = ""; // Armazena operacoes
		private $nomPermissao; // Nome de permissao simplificada
		private $usuarios = ""; // Dados Usuarios 

		function __construct($mysqli) // Construtor
		{		
			$this->mysqli = $mysqli; // Conexao com o banco de dados
		}


		// Estoque *INICIO*
		public function consultaEstoque() // Gera dados para tabela Estoque
		{
			// Busca os dados do item
			$select = "
				SELECT a.cod_item, a.item_desc, a.cod_categoria, a.saldo, b.desc_categoria
				FROM estoque a, categoria b
				WHERE a.cod_categoria = b.cod_categoria";
			$result = $this->mysqli->query($select);
			self::checaBuscaVazia($result); // Confere se o select retornou algo

			while($row = $result->fetch_assoc()){							
				$ultimaMov = self::ultimaMovimentacao($row['cod_item']); // Busca a ultima movimentacao do item e armazena
				// Gera conteudo da tabela
				$this->estoque .= "	
					<tr>
						<td>".$row['cod_item']."</td>
						<td>".$row['item_desc']."</td>
						<td>".$row['desc_categoria']."</td>
						<td>".$ultimaMov."</td>
						<td>".$row['saldo']."</td>
					</tr>
				";			  
			}
			echo $this->estoque; // Imprime as linhas da tabela
		}

		public function ultimaMovimentacao($codItem) // Busca a ultima movimentacao de um item
		{

			// Busca no bd a ultima movimentacao
			$select = "
				SELECT dat_movimento
				FROM estoque_movnto
				WHERE cod_item = '{$codItem}'
				ORDER BY dat_movimento DESC LIMIT 1";
			$result = $this->mysqli->query($select);
			$row = $result->fetch_assoc();

			return $row['dat_movimento']; // Retorna a ultima movimentacao do item
		}
		// Estoque *FIM*


		// Historico de movimentacao de estoque *INICIO*
		public function historicoMovimentacao() // Gera dados para tabela hist mov
		{
			// Busca dados das movimentacoes
			$select = "
				SELECT a.cod_item, a.cod_operacao, a.desc_operacao, a.tipo, a.qtde, a.dat_movimento, a.usuario, b.item_desc
				FROM estoque_movnto a, estoque b
				WHERE a.cod_item = b.cod_item";
			$result = $this->mysqli->query($select);
			self::checaBuscaVazia($result); // Confere se o select retornou algo

			while($row = $result->fetch_assoc()){			
				// Gera conteudo da tabela
				$this->hist_mov .= "		
				<tr>
					<td>".$row['item_desc']."</td>
					<td>".$row['cod_item']."</td>
					<td>".$row['desc_operacao']."</td>
					<td>".$row['cod_operacao']."</td>
					<td>".$row['tipo']."</td>
					<td>".$row['qtde']."</td>																						
					<td>".$row['dat_movimento']."</td>
					<td>".$row['usuario']."</td>
				</tr>";						  
			}
			echo $this->hist_mov; // Imprime as linhas da tabela
		}
		// Historico de movimentacao de estoque *FIM*


		// Movimentacao de estoque *INICIO*
		public function movimentacaoEstoque($permissao) // Gera dados para tabela movimentacao de estoque
		{
			
			self::operacoes($permissao); // Gera o select(html) com as operacoes do bd

			// Busca dados do item
			$select = "
				SELECT cod_item, item_desc, saldo
				FROM estoque
				WHERE item_desc = '{$_POST['item_desc']}'";						
			$result = $this->mysqli->query($select);							
			self::checaBuscaVazia($result); // Confere se o select retornou algo

			$row = $result->fetch_assoc();
			// Gera conteudo da tabela
			$this->movimentacao .= "		
			<tr>
				<td id='alinhamento'>".$row['cod_item']."</td>
				<td id='alinhamento'>".$row['item_desc']."</td>
				<td id='alinhamento'>".$row['saldo']."</td>
				
				<form method='POST' action='interacao_bd/update_movn_estoque.php'>
					<td>
						<div class='form-group'>			
							<select class='form-control' onchange='submitForm(this.form);' name='cod_op' required>						
							".$this->operacoes."
							</select>
						</div>					
					</td>
					<td>
						<input name='qtde' class='form-control' placeholder='Quantidade' required>
					</td>
					<td>
						<button style='width: 76%; margin-left: 12%; margin-right: 12%;' type='submit' class='btn btn-success'>Confirmar</button>
					</td>
					<input type='hidden' value='".$row['item_desc']."' name='item_desc'/>
				</form>
			</tr>";	

			echo $this->movimentacao; // Imprime a linha da tabela
		}

		public function operacoes($permissao) // Gera o select(html) com todas as operacoes
		{
			$filtro = "";
			if($permissao != 1){ // Caso o usuario nao pussua permissao total, remove a operacao deletar
				$filtro = "WHERE tipo != 'D'";
			}
			// Busca todas operacoes salvas no banco
			$select = "
				SELECT cod_operacao, desc_operacao, tipo
				FROM operacao
				{$filtro}";								
			$result = $this->mysqli->query($select);
			
			$this->operacoes .= "
			<option value=''>Operação</option>";
			// Gera as opcoes do select(html) com as operacoes do bd
			while($row = $result->fetch_assoc()){											
				$this->operacoes .= "	
				<option value='".$row['cod_operacao']."'>".$row['desc_operacao']."</option>";
			}
		}
		// Movimentacao de estoque *FIM*


		// Usuarios *INICIO*
		public function dadosUsuarios()
		{
			$select = "
				SELECT id, login, pri_nome, ult_nome, email, permissao
				FROM usuario";
			$result = $this->mysqli->query($select);
			self::checaBuscaVazia($result); // Confere se o select retornou algo

			while($row = $result->fetch_assoc()){					
				self::defineNomePermissao($row['permissao']);
				// Gera conteudo da tabela
				$this->usuarios .= "		
				<tr>
					<td id='alinhamento'>".$row['login']."</td>
					<td id='alinhamento'>".$row['pri_nome']."</td>
					<td id='alinhamento'>".$row['ult_nome']."</td>
					<td id='alinhamento'>".$row['email']."</td>
					<td id='alinhamento'>".$this->nomPermissao."</td>
					<form method='POST' action='interacao_bd/update_permissao.php'?>
						<td>
							<div class='form-group'>			
								<select class='form-control' onchange='submitForm(this.form);' name='alt_perm'>								
									<option value=''>Permissão</option>
									<option value='1'>Total</option>
									<option value='2'>Média</option>
									<option value='3'>Mínima</option>
									<option value='4'>Nenhuma</option>
								</select>
							</div>					
						</td>
						<input name='id' type=hidden value='".$row['id']."' />
					</form>
					<td align='center'><a onclick='deletaUsuario(".$row['id'].");' style='cursor: pointer;' class='fas fa-user-times fa-3x'></a></td>
				</tr>";						  
			}
			echo $this->usuarios;
		}

		public function defineNomePermissao($permissao)
		{
			// Define um nome simplificado para dada permissao
			switch($permissao)
			{
				case 1: 
					$this->nomPermissao = 'Total';
					break;
				case 2:
					$this->nomPermissao = 'Média';
					break;
				case 3:
					$this->nomPermissao = 'Mínima';
					break;
				case 4:
					$this->nomPermissao = 'Sem Acesso';
					break;
			}
		}
		// Usuarios *FIM*
		

		// Geral *INICIO*
		public function checaBuscaVazia($result)
		{
			if (empty($result)){ // Caso a busca retorne vazia, e dada uma msg de erro 
				echo '</table><h2 style="margin: auto;  width: 50%; text-align: center;">Tabela Vazia</h2>';
				$this->mysqli->close(); // Fecha conexao
				exit; // Interrompe execucao
			}
		}
		// Geral *FIM*
	}					
?>