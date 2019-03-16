	<?php session_start(); ?>
	<!-- Sidebar -->
	<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
		<a class="navbar-brand mr-1" href="consulta_estoque.php">AdminStock</a>
		<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
			<i class="fas fa-bars"></i>
		</button>
	
    <!-- Navbar -->
		<ul class="navbar-nav ml-auto">
			<span style="margin-top: auto; margin-bottom: auto; color: white; float: right;"><?php echo "".$_SESSION['pri_nome']." ".$_SESSION['ult_nome']."&nbsp;&nbsp;"?></span>
			<li class="nav-item dropdown no-arrow">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-user-circle fa-fw"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">        
					<a class="dropdown-item" href="../login/trocar_senha.html">Mudar Senha</a>
					<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Sair</a>
				</div>
			</li>	  
		</ul>
	</nav>
  
    <!-- Logout -->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Quer realmente sair?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Selecione <b>Sair</b> abaixo para finalizar sua sessão atual.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-primary" href="interacao_bd/finalizar_session.php">Sair</a>
				</div>
			</div>
		</div>
	</div>