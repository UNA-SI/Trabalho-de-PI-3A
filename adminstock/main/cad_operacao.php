<?php
require_once("../requires/connect.php");
mysqli_set_charset( $mysqli, 'utf8'); // MUDA OS DADOS DO BANCO PARA UTF-8 - **IMPORTANTE**
session_start();
// checa se a SESSION expirou
if($_SESSION['login'] == "" && $_SESSION['permissao'] == "") 
{
  	echo "<script>
			alert('Login expirado, entre novamente.');
			window.location.href='../../index.html';
		  </script>";
}
// Verifica permissão do usuário ao acesso da página
if($_SESSION['permissao'] != "1" && $_SESSION['permissao'] != "2") 
{
  	echo "<script>
			alert('Voc\u00ea n\u00e3o tem acesso a essa p\u00e1gina, fa\u00e7a o login para poder acessar.');
			window.location.href='../../tables.html';
		  </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminStock - Cadastrar Operação</title>

  <!-- Custom fonts for this template-->
  <link href="../requires/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../requires/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../requires/css/sb-admin.css" rel="stylesheet">
	
	<style>
		.nome-footer{
			font-weight: bold;
			font-size: 1.5rem;
		}	
	</style>	
</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1"  href="#">AdminStock</a>

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
		  <a class="dropdown-item" href="../login/forgot-password.html">Mudar Senha</a>
		  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Sair</a>
        </div>
      </li>	  
    </ul>
  </nav>

	<div id="wrapper">

		<!-- Menu lateral -->
		<?php require_once('menu.php');?>

		<div id="content-wrapper">
			<div class="container-fluid">

				<!-- Breadcrumbs-->
				<ol class="breadcrumb">
				  <li class="breadcrumb-item">Cadastro de Operação</li>
				</ol>

				<!-- Page Content -->
				<h1>Cadastrar Operação</h1>
				<hr>
				<div class="container">
					<div class="card card-register mx-auto mt-8">
						<div class="card-header">Novo Produto</div>
						<div class="card-body">
							<form method="POST" action="interacao_bd/insert_operacao.php">
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-12">
											<!-- DESCRIÇÃO DA OPERAÇÃO -->
											<div class="form-group">
												<input name="desc_op" class="form-control" placeholder="Desc. da Operação" required>
											</div><br>
											<!-- TIPO DE OPERAÇÃO -->
											<div class="form-group">									
												<select name="tipo_op" class="form-control" required>
												  <option value="">Tipo de Operação</option>
												  <option value="E" >Entrada</option>
												  <option value="S" >Saída</option>
												</select>
											</div>												
										</div>
									</div>
								</div>
								<input type="submit" class="btn btn-primary btn-block" value="Cadastrar">
							</form>
						</div>					
					</div>
				</div>
			</div>
		</div>

		<!-- Sticky Footer -->
		<footer class="sticky-footer">
			<div class="container my-auto">
				<div class="copyright text-center my-auto">
					<span class="nome-footer">AdminStock 2019</span>
				</div>
			</div>
		</footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
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
          <a class="btn btn-primary" href="finalizar_session.php">Sair</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../requires/vendor/jquery/jquery.min.js"></script>
  <script src="../requires/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../requires/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../requires/vendor/datatables/jquery.dataTables.js"></script>
  <script src="../requires/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../requires/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../requires/js/demo/datatables-demo.js"></script>

</body>

</html>
<?php $mysqli->close(); // fecha a conexao ?>