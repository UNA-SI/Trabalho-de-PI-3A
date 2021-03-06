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

  <title>AdminStock - Cadastrar Produto</title>

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
				<h1>Cadastrar Produto</h1>
				<hr>
				<br>
				<div class="container">
					<div class="card card-register mx-auto mt-8">
						<div class="card-header">Novo Produto</div>
						<div class="card-body">
							<form method="POST" action="interacao_bd/insert_produto.php">
								<div class="form-group">
									<div class="form-row">
										<div class="col-md-12">
											<!-- DESCRIÇÃO DO PRODUTO -->
											<div class="form-group">
												<input name="descProd" class="form-control" placeholder="Desc. do Produto" required>
											</div><br>
											<!-- CATEGORIA DO PRODUTO -->																																
											<div class="form-group">												
												<?php 
													$select = "SELECT cod_categoria, desc_categoria
													FROM categoria
													ORDER BY desc_categoria";
													$result = $mysqli->query($select);

													while($row = $result->fetch_assoc()){
															$categorias[] = $row['desc_categoria'];
															$cod_categoria[] = $row['cod_categoria'];
													}
													echo "<input list='categoria' name='codCat' class='form-control' 
													placeholder='Categoria do Produto' pattern='" . implode('|', $cod_categoria) . "' required>";                                                                                                                                                                                                                                                                             
												
													echo "<datalist id='categoria'>";
													$aux = 0;
													foreach($cod_categoria as $cod){
														echo "<option value='".$cod."'>".$categorias[$aux]."</option>";     
														$aux ++;
													}   
													echo "</datalist>"; 
												?>
																						
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