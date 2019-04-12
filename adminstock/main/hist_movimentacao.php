<?php
require_once("../requires/connect.php"); // CONEXAO COM O BD
require_once("../requires/functions.php"); // FUNCOES
require_once("interacao_bd/selectBd.php"); // FUNCOES
SESSION_START();

$permissaoPagina = 3; // Permissao da pagina atual (basica)
$funcao = new Functions($mysqli);
// Confere se o usuario realizou o login e tem permissao de acesso
$funcao->checaLogin( $_SESSION['login'], $_SESSION['permissao'], $permissaoPagina);	
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminStock - Histórico de Movimentação</title>

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

	<!-- BARRA DE NAVEGAÇÃO SUPERIOR -->
	<?php require_once('nav_bar.php');?>

	<div id="wrapper">

	<!-- Menu lateral -->
	<?php require_once('menu.php');?>
			
		<div id="content-wrapper">
			
			<div class="container-fluid">
				<!-- Page Content -->
				<h1>Histórico de Movimentação</h1>
				<hr>
				<br>		
				<!-- Tabela -->
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-table"></i>
					Histórico de Movimentação</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover tabela" id="dataTable">
								<thead>
									<tr>
										<th>Desc. Produto</th>
										<th>Cód. Produto</th>
										<th>Desc. Operação</th>
										<th>Cód. Operação</th>																												
										<th>Tipo Operação</th>
										<th>Quantidade</th>
										<th>Data Movimen.</th>
										<th>Usuário</th>
									</tr>
								</thead>
								<tbody>					
									<?php 
			  							$dados = new BuscaDados($mysqli);
			  							$dados->historicoMovimentacao(); // Gera a tabela do historico de movimentacao	
									?>   
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
      <!-- /.container-fluid -->

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

	<!-- Bootstrap core JavaScript-->
	<script src="../requires/vendor/jquery/jquery.min.js"></script>
	<script src="../requires/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<!-- SCRIPT PARA ORDERNAR A COLUNA 5 DE MANEIRA DESCENDENTE -->
	<script>
		$(document).ready(function() {
			$('.tabela').DataTable( {
				"order": [[ 6, "desc" ]] // "0" means First column and "desc" is order type; 
			} );
		} );
	</script>

	<!-- Core plugin JavaScript-->
	<script src="../requires/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Page level plugin JavaScript-->
	<script src="../requires/vendor/datatables/jquery.dataTables.js"></script>
	<script src="../requires/vendor/datatables/dataTables.bootstrap4.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="../requires/js/sb-admin.min.js"></script>

	<!-- Demo scripts for this page-->
	<script src="../requires/js/demo/datatables-demo.js"></script>
  
  
  
</head>

</body>

</html>
