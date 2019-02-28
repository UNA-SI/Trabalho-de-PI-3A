<!-- Sidebar -->
	<?php session_start(); ?>
    <?php if($_SESSION['permissao'] == 1 || $_SESSION['permissao'] == 2 || $_SESSION['permissao'] == 3) {?>
	<ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="consulta_estoque.php">
			<i class="fas fa-eye"></i>
			<span>Visualizar Estoque</span>
		</a>
      </li>
	<?php }?>
	  <li class="nav-item">
        <a class="nav-link" href="#">
			<i class="fas fa-exchange-alt"></i>
			<span>Histórico de Movimentação</span>
		</a>
      </li>		
	<?php if($_SESSION['permissao'] == 1 || $_SESSION['permissao'] == 2) {?>
	  <li class="nav-item">
        <a class="nav-link" href="cad_produto.php">
			<i class="fas fa-arrow-right"></i>
			<span>Cadastrar Produto</span>
		</a>
	  </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">
			<i class="fas fa-random"></i>
			<span>Movimentação de Estoque</span>
		</a>
      </li>	
	<?php }?>
	<?php if($_SESSION['permissao'] == 1) {?>
	  <li class="nav-item">
        <a class="nav-link" href="#">
			<i class="fas fa-clipboard-list"></i>
			<span>Cadastrar Categoria</span>
		</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">
			<i class="fas fa-clipboard-check"></i>
			<span>Cadastrar Operação</span>
		</a>
      </li>
	   <li class="nav-item">
        <a class="nav-link" href="#">
			<i class="fas fa-user"></i>
			<span>Usuários</span>
		</a>
      </li>
	<?php }?>
    </ul>