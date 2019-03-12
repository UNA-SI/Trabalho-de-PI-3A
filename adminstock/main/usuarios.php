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
if($_SESSION['permissao'] != "1") 
{
  	echo "<script>
			alert('Voc\u00ea n\u00e3o tem acesso a essa p\u00e1gina, fale com o administrador para poder acessar.');
			window.location.href='../../index.html';
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

  <title>AdminStock - Usuários</title>

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
		#alinhamento
		{
			vertical-align:middle;
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
				<h1>Usuários</h1>
				<hr>
				<br>
		
				<!-- Tabela -->
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-table"></i>
					Usuários</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover" id="dataTable">
								<thead>
									<tr>
										<th>Login</th>
										<th>Primeiro Nome</th>
										<th>Último Nome</th>
										<th>Email</th>
										<th>Permissão Atual</th>
										<th>Alterar Permissão</th>
										<th>Apagar Usuário</th>
									</tr>
								</thead>
								<tbody>
									<?php 	
										$select = "SELECT id, login, pri_nome, ult_nome, email, permissao
										FROM usuario";
										$result = $mysqli->query($select);
								
										while($row = $result->fetch_assoc()){	
											
											switch($row['permissao'])
											{
												case 1: 
													$permissao = 'Total';
													break;
												case 2:
													$permissao = 'Média';
													break;
												case 3:
													$permissao = 'Mínima';
													break;
												case 4:
													$permissao = 'Sem Acesso';
													break;
											}
											echo "		
											<tr>
												<td id='alinhamento'>".$row['login']."</td>
												<td id='alinhamento'>".$row['pri_nome']."</td>
												<td id='alinhamento'>".$row['ult_nome']."</td>
												<td id='alinhamento'>".$row['email']."</td>
												<td id='alinhamento'>".$permissao."</td>
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
										?>       
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> <!-- /.container-fluid -->
      

			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span class="nome-footer">AdminStock 2019</span>
					</div>
				</div>
			</footer>
		</div> <!-- /.content-wrapper -->
	</div> <!-- /#wrapper --> 

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

	<script>
		function submitForm(form){
			if(confirm('Tem certeza que deseja alterar a permiss\u00e3o deste usu\u00e1rio?')){
				form.submit();
			} else {
				return false;
			}
		}
		
		function deletaUsuario(link) {
			var confirma = window.confirm("Tem certeza que deseja deletar esse usu\u00e1rio?");
			if (confirma) {
				window.location.href = "interacao_bd/delete_usuario.php?BoK2sW7fUfiDLs5Zugof="+link;
			}
		}
	</script>
	
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
