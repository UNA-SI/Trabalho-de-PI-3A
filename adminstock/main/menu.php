<!-- Sidebar -->
	<?php session_start(); ?>
	<!-- PERMISSÃO MÍNIMA -->
    <?php if($_SESSION['permissao'] == 1 || $_SESSION['permissao'] == 2 || $_SESSION['permissao'] == 3) {?>
	<ul class="sidebar navbar-nav">
	<!-- VISUALIZAR ESTOQUE -->	
	  <li class="nav-item">
        <a class="nav-link" href="consulta_estoque.php">
			<i class="fas fa-eye"></i>
			<span>Consulta Estoque</span>
		</a>
      </li>
	<!-- HISTÓRICO DE MOVIMENTAÇÃO-->
	<li class="nav-item">
        <a class="nav-link" href="hist_movimentacao.php">
			<i class="fas fa-exchange-alt"></i>
			<span>Histórico de Movimentação</span>
		</a>
      </li>	
	<?php }?>
	<!-- PERMISSÃO INTERMEDIARIA
	<?php if($_SESSION['permissao'] == 1 || $_SESSION['permissao'] == 2) {?>
	<!-- CADASTRAR PRODUTO -->	
	  <li class="nav-item">
        <a class="nav-link" href="cad_produto.php">
			<i class="fas fa-arrow-right"></i>
			<span>Cadastrar Produto</span>
		</a>
	  </li>
	<!-- MOVIMENTAÇÃO DE ESTOQUE -->
	  <li class="nav-item">
        <a class="nav-link" href="movnt_estoque.php">
			<i class="fas fa-random"></i>
			<span>Movimentação de Estoque</span>
		</a>
      </li>	
	<?php }?>
	<!-- PERMISSÃO TOTAL -->
	<?php if($_SESSION['permissao'] == 1) {?>
	<!-- CADASTRAR CATEGORIA -->	
	  <li class="nav-item">
        <a class="nav-link" href="cad_categoria.php">
			<i class="fas fa-clipboard-list"></i>
			<span>Cadastrar Categoria</span>
		</a>
      </li>
	<!-- CADASTRAR OPERAÇÃO -->
	  <li class="nav-item">
        <a class="nav-link" href="cad_operacao.php">
			<i class="fas fa-clipboard-check"></i>
			<span>Cadastrar Operação</span>
		</a>
      </li>
	<!-- USUÁRIOS -->
	   <li class="nav-item">
        <a class="nav-link" href="usuarios.php">
			<i class="fas fa-user"></i>
			<span>Usuários</span>
		</a>
      </li>
	<?php }?>
    </ul>